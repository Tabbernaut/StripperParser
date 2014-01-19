<?php
/**
 * Testing StripperParser
 */

/*
    What it must do:

    A. report issues:
        a.  brackets not sitting on their own lines
        b.  a block that is not preceded by a '<type>:' statement
        c.  a block with the wrong data for its type (modify content when add is expected, etc)
        d.  missing [esc] character in script function
        e.  syntax errors, such as missing quotes, or unexpected characters on lines
        f.  modify {} blocks without match: subblocks
    B. give warnings
        a.  unknown property names ("angles", etc)
        b.  unknown event names ("OnTrigger", etc)
        c.  empty blocks
    C. give (some form of marked up) syntax highlighted/highlightable source code string
    D. allow searching through the block list
 */

// include blocks
require("lib/StripperParser/StripperParserFactory.php");


// 1. get file / contents
// 2. make stripper parser and set contents
// 3. run parse process
// 4. show output:
//      warnings, errors
//      highlighted source

//$fileOkay = "test/c7m1_docks.cfg";
$fileOkay = "test/c1m3_mall.cfg";
$fileBroken = "test/faulty.cfg";

$contentOkay = file_get_contents($fileOkay);
$contentBroken = file_get_contents($fileBroken);

$parser = StripperParserFactory::makeParser();


// good test
$parser->parse($contentOkay);
printf("Content parsed: %d errors; %d warnings.", count($parser->errors), count($parser->warnings));
if (count($parser->errors) || count($parser->warnings)) {
    print "<pre>\n";
    print_r($parser->errors);
    print_r($parser->warnings);
    print "</pre>\n";
}

/*
print "<pre>\n";
print_r($parser->getBlocks());
print "</pre>\n";
print("<br />");
*/

// faulty test
$parser->parse($contentBroken);
printf("Content parsed: %d errors; %d warnings.", count($parser->errors), count($parser->warnings));
if (count($parser->errors) || count($parser->warnings)) {
    print "<pre>\n";
    print_r($parser->errors);
    print_r($parser->warnings);
    print "</pre>\n";
}

/*
print "<pre>\n";
print_r($parser->getBlocks());
print "</pre>\n";
print("<br />");
*/


// parse all files in the test/collection/ directory:
/*
$count = 0;
$base_dir = __DIR__ . '/test/;

$directory = new RecursiveDirectoryIterator($base_dir);
$flattened = new RecursiveIteratorIterator($directory);

// Make sure the path does not contain "/.Trash*" folders and ends eith a .php or .html file
$files = new RegexIterator($flattened, '#.*\.(cfg)$#Di');

// enable dump mode so stripper/dumps files don't cause too many freaky warnings
//$parser->dumpMode = true;
*/
