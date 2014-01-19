<?php
/**
 * @package StripperParser
 */

interface StripperBlockInterface
{
}

abstract class StripperBlockAbstract implements StripperBlockInterface
{
    public $properties = array();
}

// blocks

class StripperBlockModify extends StripperBlockAbstract
{
    public $blocks = array();       // array of StripperBlockInterface
}

class StripperBlockAdd extends StripperBlockAbstract
{

}

class StripperBlockFilter extends StripperBlockAbstract
{
    
}

// subblocks

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
