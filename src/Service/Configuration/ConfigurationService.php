<?php

namespace Src\Service\Configuration;

use Src\Controller\Configuration\ConfigurationQuery;
use Src\Controller\Configuration\Request\CriterSpecification;
use Src\Controller\Configuration\Request\DateSpecification;
use Src\Definition\Comparison;
use Src\Service\DBService;
use Src\Utils\ArrayUtils;
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
        $configIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $config);
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

    public function buildWhereClause(Array $list, $isAnd)
    {
        $query = " ";
        $keyword = "OR";
        if ($isAnd) {
            $keyword = "AND";
        }

        for ($i = 0; $i < sizeof($list); $i++) {
            $query = $query . " ";
            if ($i > 0) {
                $query = $query . $keyword . " ";
            }
            $query = $query . $list[$i];
        }
        return $query;
    }

    public function buildQueryForColumn(Array $list, $column, $keyword)
    {
        $query = " ";
        for ($i = 0; $i < sizeof($list); $i++) {
            if ($i == 0) {
                $query = $query . "(";
            }

            if ($i > 0) {
                $query = $query . " " . $keyword . " ";
            }

            $query = $query . $column . " = " . $list[$i];

            if ($i == sizeof($list) - 1) {
                $query = $query . ")";
            }
        }
        return $query;
    }

    public function buildLikeQueryForColumn(CriterSpecification $spec, $column, $sqlRegex)
    {
        $query = " ";
        $orKeyword = "OR";
        $likeKeyword = "LIKE";


        $list = StringUtils::trimStringToArrayWithNonEmptyElement("|", $spec->list);

        for ($i = 0; $i < sizeof($list); $i++) {
            if ($i == 0) {
                $query = $query . "(";
            }

            if ($i > 0) {
                $query = $query . " " . $orKeyword . " ";
            }


            $regex = str_replace("{replacement}", "" . $list[$i], $sqlRegex);
            $query = $query . $column . " " . $likeKeyword . " " . "'" . $regex . "'";

            if ($i == sizeof($list) - 1) {
                $query = $query . ")";
            }
        }
        return $query;
    }

    public function buildOrAndQueryForColumn(CriterSpecification $spec, $column, $isAnd)
    {
        $keyword = "OR";
        if ($isAnd) {
            $keyword = "AND";
        }

        $list = StringUtils::trimStringToArrayWithNonEmptyElement("|", $spec->list);
        $query = $this->buildQueryForColumn($list, $column, $keyword);
        return $query;
    }

    public function buildTimeQueryForColumn(DateSpecification $spec, $column)
    {
        $query = " ";
        $betweenKeyword = "BETWEEN";
        $andKeyword = "AND";
        $greaterThanKeyword = ">";
        $greaterThanOrEqualKeyword = ">=";
        $smallerThanKeyword = "<";
        $smallerThanOrEqualKeyword = "=<";

        if ($spec->start && !$spec->end) {
            $query = $query . "(" . $column . " ";
            $query = $query . $greaterThanOrEqualKeyword . " ";
            $query = $query . "'" . $spec->start . "' " . ")";
        } else if (!$spec->start && $spec->end) {
            $query = $query . "(" . $column . " ";
            $query = $query . $smallerThanOrEqualKeyword . " ";
            $query = $query . "'" . $spec->end . "'" . ")";
        } else if (!$spec->start && !$spec->end) {
            // return blank
        } else {
            $query = $query . "(" . $column . " ";
            $query = $query . $betweenKeyword . " ";
            $query = $query . "'" . $spec->start . "' ";
            $query = $query . $andKeyword . " ";
            $query = $query . "'" . $spec->end . "'" . ")";
        }
        return $query;
    }

    public function buildOrderByClause(array $order_by_list)
    {
        $query = " ";
        $orderByKeyword = "ORDER BY";
        $descKeyword = "DESC";
        $ascKeyword = "ASC";

        for ($i = 0; $i < sizeof($order_by_list); $i++) {
            if ($i == 0) {
                $query = $query . $orderByKeyword . " ";
            }

            if ($i > 0) {
                $query = $query . ", ";
            }

            $query = $query . $order_by_list[$i]->column . " ";
            if ($order_by_list[$i]->isAscending) {
                $query = $query . $ascKeyword;
            } else {
                $query = $query . $descKeyword;
            }
        }
        return $query;
    }


    public function searchDB(ConfigurationQuery $request)
    {
        $table = $this->table();
        $queryList = array();


        // For update_order
        $update_order_spec = $request->update_order_spec;
        $update_order_query = "";
        if ($update_order_spec->isAnd) {
            // TODO
            // throw error syntax
        } else {
            $update_order_query = $this->buildOrAndQueryForColumn($update_order_spec, "update_order", false);
        }

        array_push($queryList, $update_order_query);

        // For type
        $type_spec = $request->type_spec;
        $type_query = "";
        if ($type_spec->isAnd) {
            // TODO
            // throw error syntax
        } else {
            $type_query = $this->buildOrAndQueryForColumn($type_spec, "type", false);
        }

        array_push($queryList, $type_query);

        // For scopes
        $scope_spec = $request->scopes_spec;
        $scope_query = $this->buildLikeQueryForColumn($scope_spec, "scopes", "{replacement}%");
        array_push($queryList, $scope_query);

        // For category
        $category_spec = $request->category_spec;
        $category_query = $this->buildOrAndQueryForColumn($category_spec, "category", $category_spec->isAnd);
        array_push($queryList, $category_query);


        if (!$request->is_deleted) {
            $isDeleted_query = " is_deleted = 0";
        } else {
            $isDeleted_query = " is_deleted = 1";
        }
        array_push($queryList, $isDeleted_query);

        if (!$request->is_activated) {
            $isActivated_query = " is_activated = 0";
        } else {
            $isActivated_query = " is_activated = 1";
        }

        array_push($queryList, $isActivated_query);

        // For created_timestamp
        $created_timestamp_spec = $request->created_timestamp_spec;
        $created_timestamp_query = $this->buildTimeQueryForColumn($created_timestamp_spec, "created_timestamp");
        array_push($queryList, $created_timestamp_query);

        // For last_updated_timestamp
        $last_updated_timestamp_spec = $request->last_updated_timestamp_spec;
        $last_updated_timestamp_query = $this->buildTimeQueryForColumn($last_updated_timestamp_spec, "last_updated_timestamp");
        array_push($queryList, $last_updated_timestamp_query);

        $queryList = ArrayUtils::arrayByRemovingEmptyElement($queryList);
//        var_dump($queryList);

        // For id
        $id_spec = $request->id_spec;
        $id_query = $this->buildOrAndQueryForColumn($id_spec, "id", $id_spec->isAnd);
        $whereStatement = $id_query . " AND (";
        $whereStatement = $whereStatement . $this->buildWhereClause($queryList, $request->isAnd) . ")";
        $whereStatement = $whereStatement . $this->buildOrderByClause($request->order_by_list);


        $statement = "
            SELECT
            *
            FROM
            $table
            WHERE $whereStatement;
            ";

//        var_dump($statement);
        return parent::queryDB($statement);
    }
}
