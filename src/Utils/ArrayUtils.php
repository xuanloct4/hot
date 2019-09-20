<?php
    namespace Src\Utils;
    
   	class ArrayUtils {
		public static function convertToObject($array) {
		    $object = new stdClass();
		    foreach ($array as $key => $value) {
		        if (is_array($value)) {
		            $value = convertToObject($value);
		        }
		        $object->$key = $value;
		    }
		    return $object;
		}
		
	}