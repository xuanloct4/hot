<?php
    namespace Src\Entity;
    
    class Person{
        // table name
        public static $table_name = "Person";
        
        // table columns
        public $id;
        public $firstname;
        public $lastname;
        public $firstparent_id;
        public $secondparent_id;
        
        //                public function __construct($id, $firstname,$lastname,$firstparent_id,$secondparent_id) {
        //                    $this->id = $id;
        //                    $this->firstname = $firstname;
        //                    $this->lastname = $lastname;
        //                    $this->firstparent_id = $firstparent_id;
        //                    $this->secondparent_id = $secondparent_id;
        //                }
        
        public function __construct() {
            
        }
    }
