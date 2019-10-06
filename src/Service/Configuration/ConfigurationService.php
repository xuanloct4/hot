<?php

namespace Src\Service\Configuration;
use Src\Definition\Comparison;
use Src\System\Configuration;
use Src\Utils\StringUtils;

class ConfigurationService
{

    private $db = null;
    private $table;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        $this->db = Configuration::getInstance()->getConnection();
        $this->table = \Src\Entity\Configuration\Configuration::table();
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ConfigurationService();
        }

        return self::$instance;
    }

    // CRUD
    public function findAll()
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table;
            ";

        try {
            $statement = $this->db->query($statement);
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Configuration\Configuration');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE id = ?;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Configuration\Configuration');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByConfigIds($config, $scopes)
    {
        $configIds = StringUtils::trimStringToArrayWithNonEmptyElement(",",$config);
        $configurations = array();
        for ($i = 0; $i < sizeof($configIds); $i++) {
            $configId = $configIds[$i];
            $c = ConfigurationService::getInstance()->find($configId);
            if (sizeof($c) > 0) {
                foreach (StringUtils::getScopes($scopes) as $scope) {
                    foreach (StringUtils::getScopes($c[0]->scopes) as $configScope) {
                        $isScoped = StringUtils::compareScope($scope, $configScope);
                        if ($isScoped == Comparison::descending || $isScoped == Comparison::equal) {
                            array_push($configurations, $c[0]);
                        }
                    }
                }
            }
        }

        return $configurations;
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO $this->table 
            (uris, binary, strings, update_order, type, scopes, is_deleted, is_activated)
            VALUES
            (:uris, :binary, :strings, :update_order, :type, :scopes, :is_deleted, :is_activated);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'uris' => $input['uris'],
                'binary' => $input['binary'],
                'strings' => $input['strings'],
                'update_order' => $input['update_order'],
                'type' => $input['type'],
                'scopes' => $input['scopes'],
                'is_deleted' => $input['is_deleted'],
                'is_activated' => $input['is_activated']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE $this->table
            SET 
            uris = :uris,
            binary  = :binary,
            strings = :strings,
            update_order = :update_order,
            type = :type,
            scopes  = :scopes,
            is_deleted = :is_deleted,
            is_activated = :is_activated
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'uris' => $input['uris'],
                'binary' => $input['binary'],
                'strings' => $input['strings'],
                'update_order' => $input['update_order'],
                'type' => $input['type'],
                'scopes' => $input['scopes'],
                'is_deleted' => $input['is_deleted'],
                'is_activated' => $input['is_activated']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM $this->table
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
