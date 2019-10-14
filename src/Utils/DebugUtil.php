<?php

namespace Src\Utils;


class DebugUtil
{
    public static function get_calling_class() {

        //get the trace
        $trace = debug_backtrace();

        // Get the class that is asking for who awoke it
        $class = $trace[1]['class'];

        // +1 to i cos we have to account for calling this function
        for ( $i=1; $i < sizeof($trace); $i++ ) {
            if ( isset( $trace[$i] ) ) // is it set?
                if ( $class != $trace[$i]['class'] ) // is it a different class
                    return $trace[$i]['class'];
        }
    }

    public static function get_calling_method() {
        //get the trace
        $trace = debug_backtrace();

        // Get the class that is asking for who awoke it
        $method = $trace[1]['function'];

        return $method;
    }

    public static function get_this_class() {
        //get the trace
        $trace = debug_backtrace();

        var_dump($trace);
        // Get the class that is asking for who awoke it
        $class = $trace[1]['class'];
        return $class;
    }

    public static function get_trace() {
        $trace = debug_backtrace();
        $arr = array();
        // +1 to i cos we have to account for calling this function
        for ( $i=0; $i < sizeof($trace); $i++ ) {
            array_push($arr, $trace[$i]);
        }
        return $arr;
    }
}

class Trace
{
    public $file; //String
    public $line; //int
    public $function; //String
    public $class; //String
    public $type; //String
    public $args; //Array
    public $object; //object

}