<?php
/**
 * @version 0.9.1
 * @package StripperParser
 */

// define modes
define("STRP_MODE_UNKNOWN",     0);
define("STRP_MODE_ADD",         1);
define("STRP_MODE_MODIFY",      2);
define("STRP_MODE_FILTER",      3);

define("STRP_SUBMODE_MATCH",    1);
define("STRP_SUBMODE_INSERT",   2);
define("STRP_SUBMODE_DELETE",   3);
define("STRP_SUBMODE_REPLACE",  4);

// include blocks
require("StripperBlock/StripperBlock.php");


class StripperParser
{
    protected $_content;
    protected $_config;

    protected $_blockMode;
    protected $_blockSubMode;
    protected $_bracketLevel;
    protected $_lineNumber;

    protected $_blocks = array();       // array of StripperBlockInterface
    protected $_lastBlock = -1;
    protected $_lastSubBlock = -1;

    public $errors = array();
    public $warnings = array();

    public $dumpMode = false;           // set to true to allow/ignore { on same line as content

    /**
     * @param StripperConfigInterface $config
     */
    public function __construct(StripperConfigInterface $config)
    {
        $this->_config = $config;
    }

    /**
     * @param  string $contentString
     * @return bool
     */
    public function parse($contentString)
    {
        if (is_null($contentString) || !is_string($contentString) || !strlen($contentString)) {
            return false;
        }

        $content = explode("\n", str_replace("\r", '', $contentString));
        $this->_content = $content;

        // set start situation
        $this->_lineNumber = 0;
        $this->_blockMode = STRP_MODE_UNKNOWN;     // add/modify/filter
        $this->_blockSubMode = STRP_MODE_UNKNOWN;  // modify: match/insert/delete/replace
        $this->_bracketLevel = 0;                  // depth of bracketing

        $this->_blocks = array();
        $this->_lastBlock = -1;
        $this->_lastSubBlock = -1;

        $this->errors = array();
        $this->warnings = array();
        

        // dump mode: only entity list
        if ($this->dumpMode) {
            $this->_blockMode = STRP_MODE_ADD;
        }

        // split up content into lines
        // parse each line in light of expected content

        foreach ($content as $line)
        {
            $this->_lineNumber++;

            // commented or empty line (ignore)
            if (preg_match("/^\s*;/is", $line) || preg_match("/^\s*$/is", $line)) {
                continue;
            }

            // check for mode changer: modifier lines
            if (preg_match("/^\s*([a-z]+)(:?)(.*?)\s*$/is", $line, $match)) {
                $this->_parseLineModifier($line, $match[1], $match[3], (strlen($match[2])));
                continue;
            }

            // check for property value lines
            if (preg_match('/^\s*"([a-z_0-9\.]+)"\s+"([^"]*?)"\s*?(.*)?$/is', $line, $match)) {
                $this->_parseLineProperty($line, $match[1], $match[2], $match[3]);
                continue;
            }

            // check for bracket lines
            if (preg_match('/^\s*}\s*{\s*$/is', $line)) {
                // dump style }{ brackets
                if (!$this->dumpMode) {
                    $this->_addError(
                        'error',
                        sprintf('Brackets must be placed on a separate line;'
                            .   ' do not place a closing bracket on the same line as an opening bracket.'),
                        $this->_lineNumber
                    );
                }
                
                $this->_parseClosingBracket();
                $this->_parseOpeningBracket();
                continue;
            }
            else if (preg_match('/^\s*({|})\s*(.*)?$/is', $line, $match)) {
                // bracket line check
                if (strlen($match[2])) {
                    $this->_addError(
                        'error',
                        sprintf('Brackets must be placed on a separate line;'
                            .   ' no other content may appear the same line. (%s)', $match[2]),
                        $this->_lineNumber
                    );
                    // open / close bracket anyway, to avoid problems
                    if ($match[1] == '{') {
                        $this->_parseOpeningBracket();
                    } else if ($match[1] == '}') {
                        $this->_parseClosingBracket();
                    }
                    continue;
                }

                if ($match[1] == '{') {
                    // are we expecting a block opening?
                    if (!$this->_parseOpeningBracket()) {
                        continue;
                    }
                } else {
                    // are we expecting a block closing?
                    if (!$this->_parseClosingBracket()) {
                        continue;
                    }
                }
                continue;
            }

            // unexpected line!
            //  try to determine what it should have been?
            $this->_addError(
                'error',
                sprintf("Syntax error; uninterpretable line content: '%s'.", trim($line)),
                $this->_lineNumber
            );
        }

        return (!count($this->errors));
    }

    /**
     * @return array    numerical, with StripperBlockInterface's
     */
    public function getBlocks()
    {
        return $this->_blocks;
    }



    /**
     * Parses a line with expected format: <mode>:
     * @param  string   $line
     * @param  string   $modifier
     * @param  string   $extraPost      the junk part after the first word / :
     * @param  boolean  $colon
     * @return void
     */
    protected function _parseLineModifier($line, $modifier, $extraPost, $colon = true)
    {

        // unexpected time? in any bracket is wrong
        if (preg_match("/(add|modify|filter)/is", $modifier)) {
            if ($this->_bracketLevel > 0) {
                $this->_addError(
                    'error',
                    sprintf('Unexpected mode modifier (%s). '
                        .   'This modifier may only appear at root level.',
                        strtoupper($modifier), $this->_bracketLevel),
                    $this->_lineNumber
                );
                return;
            }
        } else if (preg_match("/(match|insert|delete|replace)/is", $modifier)) {
            if ($this->_bracketLevel != 1) {
                $this->_addError(
                    'error',
                    sprintf('Unexpected modify submode modifier (%s). '
                        .   'This modifier may only appear in a MODIFY block.',
                        strtoupper($modifier), $this->_bracketLevel),
                    $this->_lineNumber
                );
                return;
            }
        }
        else {
            $this->_addError(
                'error',
                'Uninterpretable line.',
                $this->_lineNumber
            );
            return;
        }

        // missing colon
        if (!$colon) {
            $this->_addError(
                'error',
                sprintf('Found mode modifier (%s) not followed by ":".', strtoupper($modifier)),
                $this->_lineNumber
            );
            return;
        }

        // catch problems with the line
        if (strlen($extraPost)) {
            $this->_addError(
                'error',
                (strpos($extraPost, '{') !== false)
                    ?   'The block opener bracket ("{") must be on its own line.'
                    :   'No non-whitespace characters allowed after (sub)mode modifier.',
                $this->_lineNumber
            );
            return;
        }

        // set stripper mode
        switch ($modifier) {

            case "add":
                $this->_blockMode = STRP_MODE_ADD;
                break;

            case "modify":
                $this->_blockMode = STRP_MODE_MODIFY;
                break;

            case "filter":
                $this->_blockMode = STRP_MODE_FILTER;
                break;

            case "match":
                $this->_blockSubMode = STRP_SUBMODE_MATCH;
                break;

            case "insert":
                $this->_blockSubMode = STRP_SUBMODE_INSERT;
                break;

            case "delete":
                $this->_blockSubMode = STRP_SUBMODE_DELETE;
                break;

            case "replace":
                $this->_blockSubMode = STRP_SUBMODE_REPLACE;
                break;

            // default left out on purpose
        }
    }


    /**
     * Parses a line with expected format: "property" "value"
     * @param  string   $line
     * @param  string   $property
     * @param  string   $value
     * @param  boolean  $extraPost      junk (such as a ;-comment)
     * @return boolean
     */
    protected function _parseLineProperty($line, $property, $value, $extraPost)
    {
        // are comments allowed in stripper lines?
        // I'm assuming they aren't
     
        $extraPost = trim($extraPost);

        if (strlen($extraPost)) {
            $this->_addError(
                'error',
                'Unexpected content following the property and value content. '
                    .   'Property statement must be no other or more than: "(property)" "(value)". '
                    .   '(Tip: check for embedded quotes (").)',
                $this->_lineNumber
            );
            return false;
        }

        // check if it is a known property
        if (!$this->_config->propertyExists($property)) {
            $this->_addError(
                'warning',
                sprintf("Unknown property name: '%s' (with value: '%s').", $property, trim($value)),
                $this->_lineNumber
            );
            return false;
        }

        // evaluate property/value combo
        $validate = $this->_config->validatePropertyValue($property, $value);

        if (is_null($validate) || !is_array($validate) || !isset($validate['validates'])) {
            throw new Exception("Config->validatePropertyValue returns incorrect validation array.");
        }

        if (isset($validate['warnings']) && is_array($validate['warnings'])) {
            foreach ($validate['warnings'] as $warning) {
                $this->_addError('warning', $warning, $this->_lineNumber);
            }
        }
        if (isset($validate['errors']) && is_array($validate['errors'])) {
            foreach ($validate['errors'] as $error) {
                $this->_addError('error', $error, $this->_lineNumber);
            }

            // stop processing if errors
            if (count($validate['errors'])) {
                return false;
            }
        }

        // assign the line to the current block
        if ($this->_bracketLevel == 1) {
            if ($this->_blockMode == STRP_MODE_UNKNOWN) {
                // ignored
                return false;
            }
            else if ($this->_blockMode == STRP_MODE_MODIFY) {
                return false;
            }
            
            $this->_blocks[$this->_lastBlock]->properties[] = array(
                'property' => $property,
                'value' => $value,
            );

        } else if ($this->_bracketLevel == 2) {
            if ($this->_blockSubMode == STRP_MODE_UNKNOWN) {
                // ignored
                return false;
            }

            $this->_blocks[$this->_lastBlock]->blocks[$this->_lastSubBlock]->properties[] = array(
                'property' => $property,
                'value' => $value,
            );
        } else {
            // outside of expected block level
            $this->_addError(
                'error',
                sprintf("Unexpected property statement; outside of any valid block scope (prop: %s => %s)",
                    $property, $value),
                $this->_lineNumber
            );
            return false;
        }

        return true;
    }

    /**
     * Parses occurrence opening brackets {}
     * @return void
     */
    protected function _parseOpeningBracket()
    {
        if ($this->_bracketLevel > 1) {
            $this->_addError(
                'error',
                sprintf('Unexpected opening bracket at deepest possible block level (%d). '
                    .   '(Did you forget a closing bracket?)',
                    $this->_bracketLevel),
                $this->_lineNumber
            );
            return false;
        }
        else if ($this->_blockMode == STRP_MODE_UNKNOWN) {
            $this->_addError(
                'error',
                'Unexpected opening bracket without any preceding ADD/MODIFY/FILTER modifier. '
                .   'This block will not have any effect.',
                $this->_lineNumber
            );
            // increment anyway
            $this->_bracketLevel++;
            return false;
        }
        else if ($this->_bracketLevel > 0 && $this->_blockSubMode == STRP_MODE_UNKNOWN) {
            $this->_addError(
                'error',
                'Unexpected opening bracket for a MODIFY block without a preceding '
                .   'MATCH/INSERT/DELETE/REPLACE modifier.',
                $this->_lineNumber
            );
            // increment anyway
            //$this->_bracketLevel++;
            return false;
        }
        else if ($this->_bracketLevel > 0 && $this->_blockMode != STRP_MODE_MODIFY) {
            $this->_addError(
                'error',
                'Unexpected opening bracket inside a top level block of the wrong type. '
                .   'Only a MODIFY block may have sub-blocks.',
                $this->_lineNumber
            );
            return false;
        }

        // open block
        $this->_bracketLevel++;
        $block = null;

        if ($this->_bracketLevel == 1) {
            switch ($this->_blockMode) {
                case STRP_MODE_ADD:
                    $block = new StripperBlockAdd();
                    break;
                case STRP_MODE_MODIFY:
                    $block = new StripperBlockModify();
                    break;
                case STRP_MODE_FILTER:
                    $block = new StripperBlockFilter();
                    break;
            }

            if ($block !== null) {
                $this->_blocks[] = $block;
                $this->_lastBlock++;
                $this->_lastSubBlock = -1;
                $this->_blockSubMode = STRP_MODE_UNKNOWN;
            }

        } else if ($this->_bracketLevel == 2) {
            switch ($this->_blockSubMode) {
                case STRP_SUBMODE_MATCH:
                    $block = new StripperBlockMatch();
                    break;
                case STRP_SUBMODE_INSERT:
                    $block = new StripperBlockInsert();
                    break;
                case STRP_SUBMODE_DELETE:
                    $block = new StripperBlockDelete();
                    break;
                case STRP_SUBMODE_REPLACE:
                    $block = new StripperBlockReplace();
                    break;
            }

            if ($block !== null) {
                $this->_blocks[$this->_lastBlock]->blocks[] = $block;
                $this->_lastSubBlock++;
            }
        }

        return true;
    }


    /**
     * Parses occurrence closing brackets {}
     * @return bool
     */
    protected function _parseClosingBracket()
    {
        if ($this->_bracketLevel < 1) {
            $this->_addError(
                'error',
                'Unexpected closing bracket at root block level. '
                    .   '(Found no opened ADD/MODIFY/FILTER block that can be closed.)',
                $this->_lineNumber
            );
            return false;
        }
        else if ($this->_bracketLevel > 1 && $this->_blockSubMode == STRP_MODE_UNKNOWN) {
            $this->_addError(
                'error',
                'Unexpected closing bracket on submode block level. '
                    .   '(Found no opened MATCH/INSERT/DELETE/REPLACE block that can be closed.)',
                $this->_lineNumber
            );
            return false;
        }
        else if ($this->_blockMode == STRP_MODE_UNKNOWN) {
            $this->_addError(
                'error',
                'Unexpected closing bracket. No valid opened blocks.',
                $this->_lineNumber
            );
            return false;
        }

        // check presence of required MATCH block in MODIFY
        if ($this->_blockMode == STRP_MODE_MODIFY) {

            if ($this->_blockSubMode == STRP_MODE_UNKNOWN) {
                // closing modify block
                $found = false;
                foreach ($this->_blocks[$this->_lastBlock]->blocks as $block) {
                    if ($block instanceof StripperBlockMatch) {
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $this->_addError(
                        'error',
                        'MODIFY block requires a MATCH sub-block.',
                        $this->_lineNumber
                    );
                }
            } else if ($this->_bracketLevel == 2) {
                // closing sub-block (but only if we actually opened it to this level!)
                if (!count($this->_blocks[$this->_lastBlock]->blocks[$this->_lastSubBlock]->properties)) {
                    $this->_addError(
                        'warning',
                        'Sub-block closed without any (valid) content.',
                        $this->_lineNumber
                    );
                }

                // reset submode (not a remembered state like top-level blockMode)
                $this->_blockSubMode = STRP_MODE_UNKNOWN;
            }

        } else {
            // warn for empty blocks
            if (!count($this->_blocks[$this->_lastBlock]->properties)) {
                $this->_addError(
                    'warning',
                    'Block closed without any (valid) content.',
                    $this->_lineNumber
                );
            }
        }

        $this->_bracketLevel--;
        return true;
    }


    /**
     * @param string $type    warning / error
     * @param string $message
     * @return void
     */
    protected function _addError($type, $message, $lineNumber = null)
    {
        switch ($type) {

            case 'warning':
                $this->warnings[] = array(
                    'message' => $message,
                    'line' => $lineNumber,
                );
                break;

            default:
                $this->errors[] = array(
                    'message' => $message,
                    'line' => $lineNumber,
                );
        }
    }
}