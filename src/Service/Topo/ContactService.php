<?php

namespace Src\Service\Topo;

use Src\Entity\Topo\Contact;
use Src\System\Configuration;

class ContactService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ContactService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Contact();
    }

    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (io, input_ad, output_ad, max_input, min_input, max_output, min_output, frequency, wave_shape, input_oscillation_function, output_oscillation_function, name)
//            VALUES
//            (:io, :input_ad, :output_ad, :max_input, :min_input, :max_output, :min_output, :frequency, :wave_shape, :input_oscillation_function, :output_oscillation_function, :name);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'io' => $input['io'],
//                'input_ad' => $input['input_ad'],
//                'output_ad' => $input['output_ad'],
//                'max_input' => $input['max_input'],
//                'min_input' => $input['min_input'],
//                'max_output' => $input['max_output'],
//                'min_output' => $input['min_output'],
//                'frequency' => $input['frequency'],
//                'wave_shape' => $input['wave_shape'],
//                'input_oscillation_function' => $input['input_oscillation_function'],
//                'output_oscillation_function' => $input['output_oscillation_function'],
//                'name' => $input['name']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
//
//    public function update($id, Array $input)
//    {
//        $statement = "
//            UPDATE $this->table
//            SET
//            io = :io,
//            input_ad  = :input_ad,
//            output_ad = :output_ad,
//            max_input = :max_input,
//            min_input  = :min_input,
//            max_output = :max_output,
//            min_output = :min_output,
//            frequency = :frequency,
//            wave_shape  = :wave_shape,
//            input_oscillation_function = :input_oscillation_function,
//            output_oscillation_function = :output_oscillation_function,
//            name = :name
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$id,
//                'io' => $input['io'],
//                'input_ad' => $input['input_ad'],
//                'output_ad' => $input['output_ad'],
//                'max_input' => $input['max_input'],
//                'min_input' => $input['min_input'],
//                'max_output' => $input['max_output'],
//                'min_output' => $input['min_output'],
//                'frequency' => $input['frequency'],
//                'wave_shape' => $input['wave_shape'],
//                'input_oscillation_function' => $input['input_oscillation_function'],
//                'output_oscillation_function' => $input['output_oscillation_function'],
//                'name' => $input['name']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}