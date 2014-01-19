<?php
/**
 * @package StripperParser
 */

// include blocks
require("StripperParser.php");
require("StripperConfig/StripperConfig.php");

class StripperParserFactory
{
    /**
     * @return StripperParser
     */
    public static function makeParser()
    {
        $config = new StripperConfig();

        // can remove empty values warning -- make this into a real configurable property
        //$config->warnOnEmptyValue = false;

        $parser = new StripperParser($config);
        return $parser;
    }

}