<?php
    namespace Src\Entity;


    interface iEntity
    {
        // table name
        public static function table();
    }

    abstract class Entity implements iEntity
    {

    }
