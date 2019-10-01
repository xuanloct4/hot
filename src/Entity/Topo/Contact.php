<?php

namespace Src\Entity\Topo;

class Contact
{
    // table name
    public static $table_name = "contact";

    // table columns
    public $id;
    public $io;
    public $input_ad;
    public $output_ad;
    public $max_input;
    public $min_input;
    public $max_output;
    public $min_output;
    public $frequency;
    public $wave_shape;
    public $input_oscillation_function;
    public $output_oscillation_function;
    public $name;

    public function __construct()
    {

    }
}
