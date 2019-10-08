<?php

namespace Src\Service\Configuration;
use Src\Definition\Comparison;
use Src\Service\DBService;
use Src\System\Configuration;
use Src\Utils\StringUtils;

class ConfigurationService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ConfigurationService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new \Src\Entity\Configuration\Configuration();
    }

    // CRUD
    public function findByConfigIds($config, $scopes)
    {
        $configIds = StringUtils::trimStringToArrayWithNonEmptyElement(",",$config);
        $configurations = array();
        for ($i = 0; $i < sizeof($configIds); $i++) {
            $configId = $configIds[$i];
            $c = ConfigurationService::getInstance()->findFirst($configId);
//            var_dump($c);
            if ($c != null) {
                foreach (StringUtils::getScopes($scopes) as $scope) {
                    foreach (StringUtils::getScopes($c->scopes) as $configScope) {
                        $isScoped = StringUtils::compareScope($scope, $configScope);
                        if ($isScoped == Comparison::descending || $isScoped == Comparison::equal) {
                            array_push($configurations, $c);
                        }
                    }
                }
            }
        }

        return $configurations;
    }

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (uris, binary, strings, update_order, type, scopes, is_deleted, is_activated)
//            VALUES
//            (:uris, :binary, :strings, :update_order, :type, :scopes, :is_deleted, :is_activated);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'uris' => $input['uris'],
//                'binary' => $input['binary'],
//                'strings' => $input['strings'],
//                'update_order' => $input['update_order'],
//                'type' => $input['type'],
//                'scopes' => $input['scopes'],
//                'is_deleted' => $input['is_deleted'],
//                'is_activated' => $input['is_activated']
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
//            uris = :uris,
//            binary  = :binary,
//            strings = :strings,
//            update_order = :update_order,
//            type = :type,
//            scopes  = :scopes,
//            is_deleted = :is_deleted,
//            is_activated = :is_activated
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int) $id,
//                'uris' => $input['uris'],
//                'binary' => $input['binary'],
//                'strings' => $input['strings'],
//                'update_order' => $input['update_order'],
//                'type' => $input['type'],
//                'scopes' => $input['scopes'],
//                'is_deleted' => $input['is_deleted'],
//                'is_activated' => $input['is_activated']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}
