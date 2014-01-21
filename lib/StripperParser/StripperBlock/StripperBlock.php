<?php
/**
 * @package StripperParser
 */

interface StripperBlockInterface
{
    /**
     * @param string $property
     * @param string $value
     */
    public function addProperty($property, $value);

    /**
     * @return array        associative array:
     *                      'validates' => bool/null,
     *                      'errors' => array(),
     *                      'warnings' => array(),
     */
    public function validate();
}

abstract class StripperBlockAbstract implements StripperBlockInterface
{
    public $properties = array();
    protected $_errors = array();
    protected $_warnings = array();


    public function addProperty($property, $value) {

        // use StripperConfig->duplicateAllowed($property) to find out 
        // whether a property should be warned about when having duplicates
        
        /*
            // duplicate property checking only makes sense if we
            // make a distinction between actual properties and trigger/event lines (which you can have multiples of)
        if (isset($this->properties[$property])) {
            $this->_warnings[] = sprintf(
                "Duplicate property ('%s'). Previous value will be overwritten ('%s' => '%s').",
                $property,
                $this->properties[$property],
                $value
            );
        }
        */
       
        $this->properties[] = array('property' => $property, 'value' => $value);
    }

    public function validate()
    {
        $validate = array(
            'validates' => null,
            'errors' => array(),
            'warnings' => array(),
        );

        // add errors previously added
        $validate['errors'] = array_merge($validate['errors'], $this->_errors);
        $validate['warnings'] = array_merge($validate['warnings'], $this->_warnings);

        // warn for empty block
        if (!count($this->properties)) {
            $validate['validates'] = false;
            $validate['errors'][] = 'Block closed without any (valid) property/value statements.';
            return $validate;
        }

        // check property content combinations
        // TO DO
        
        $validate['validates'] = (!count($validate['errors']));

        return $validate;
    }
}

// blocks

class StripperBlockModify extends StripperBlockAbstract
{
    public $blocks = array();       // array of StripperBlockInterface

    public function validate()
    {
        $validate = array(
            'validates' => null,
            'errors' => array(),
            'warnings' => array(),
        );

        $counts = array(
            'match' => 0,
            'insert' => 0,
            'delete' => 0,
            'replace' => 0,
        );
        
        // this block has no content of its own, check children intead
        foreach ($this->blocks as $block) {
            $blockval = $block->validate();

            if ($blockval['validates'] !== null) {
                $validate['errors'] = array_merge($validate['errors'], $blockval['errors']);
                $validate['warnings'] = array_merge($validate['warnings'], $blockval['warnings']);
            }

            if ($block instanceof StripperBlockMatch) {
                $counts['match']++;
            } elseif ($block instanceof StripperBlockInsert) {
                $counts['insert']++;
            } elseif ($block instanceof StripperBlockDelete) {
                $counts['delete']++;
            } elseif ($block instanceof StripperBlockReplace) {
                $counts['replace']++;
            }
        }

        // check block combinations for modify statement
        if ($counts['match'] == 0) {
            $validate['errors'][] = 'No MATCH sub-block found in MODIFY block. This sub-block is required.';
        } else if ($counts['match'] > 1) {
            $validate['errors'][] = 'More than one MATCH sub-block in MODIFY block. Only one allowed.';
        }

        if ($counts['insert'] + $counts['delete'] + $counts['replace'] == 0) {
            $validate['errors'][] = 'No INSERT/DELETE/REPLACE sub-blocks in MODIFY block.'
                                  . ' This block will have no effect';
        }

        if ($counts['insert'] > 1 || $counts['delete'] > 1 || $counts['replace'] > 1) {
            $validate['errors'][] = 'Duplicate INSERT/DELETE/REPLACE sub-blocks found in MODIFY block.'
                                  . ' Only one per type allowed.';
        }

        $validate['validates'] = (!count($validate['errors']));
        return $validate;
    }
}

class StripperBlockAdd extends StripperBlockAbstract
{

}

class StripperBlockFilter extends StripperBlockAbstract
{
    
}

// sub-blocks

class StripperBlockMatch extends StripperBlockAbstract
{
}

class StripperBlockInsert extends StripperBlockAbstract
{
    
}

class StripperBlockDelete extends StripperBlockAbstract
{
    
}

class StripperBlockReplace extends StripperBlockAbstract
{
    
}
