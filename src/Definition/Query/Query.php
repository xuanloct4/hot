<?php

namespace Src\Definition\Query;

use Src\Utils\ArrayUtils;
use Src\Utils\StringUtils;

class Query
{
    public $queryParts;

    public function __construct()
    {
        $this->queryParts = array();
    }

    public static function initFromRequest(SearchRequest $searchRequest) {
        $query = Query();

        return $query;
    }

    public function composeQuery()
    {
        $composedQuery = "";
        for ($i = 0; $i < sizeof($this->queryParts); $i++) {
            $composedQuery .= $this->queryParts[$i]->composeQueryPart();
        }
        var_dump($composedQuery);
        return $composedQuery;
    }
}

class QueryParam
{
    public $key;
    public $value;
    public $order;
}

class QueryPart
{
    public $keyword;
    public $operator; //QueryParam
    public $params;   //QueryParam

    public function composeQueryPart()
    {
        $break = " ";
        $query = "";
        switch ($this->operator) {
            case  Operator::equal:
            case  Operator::not_equal:
            case  Operator::greater_than:
            case  Operator::smaller_than:
            case  Operator::greater_than_or_equal:
            case  Operator::smaller_than_or_equal:
            case  Operator::like:
                $query = $break;
                if (sizeof($this->params) > 0) {
                    $key = $this->params[0]->key;
                    $value = QueryPart::getParamValue($this->params[0]->value);
                    $query = "$key".$break."$this->operator".$break."$value"."$break";
                }
                break;
            case  Operator::and_:
            case  Operator::or_:
            $query = $break;
            if (sizeof($this->params) > 0) {
                $sortParams = ArrayUtils::sort($this->params, array("order"));
                for ($i = 0; $i < sizeof($sortParams); $i++) {
                    $param = $sortParams[$i];
                    if ($i>0) {
                        $query .= "$this->operator";
                    }

                    $query .= $break;
                    $composedValue = QueryPart::getParamValue($param->value);
                    if (!StringUtils::isNullOrEmpty($param->key)) {
                        $query .= "$param->key";
                    } else if (!StringUtils::isNullOrEmpty($composedValue)) {
                        $query .= "$composedValue";
                    } else {
                        $query .= "";
                    }
                }
            }
                break;
            case  Operator::is_null:
                if (sizeof($this->params) > 0) {
                    $param = $this->params[0];
                    $composedValue = QueryPart::getParamValue($param->value);
                    if (!StringUtils::isNullOrEmpty($param->key)) {
                        $query .= "$param->key";
                    } else if (!StringUtils::isNullOrEmpty($composedValue)) {
                        $query .= "$composedValue";
                    } else {
                        $query .= "";
                    }

                    $query .= "$break"."$this->operator"."$break";
                }
                break;
            case  Operator::not_between:
            case  Operator::between:
            if (sizeof($this->params) > 0) {
                $param = $this->params[0];
                $composedValue = QueryPart::getParamValue($param->value);
                if (!StringUtils::isNullOrEmpty($param->key)) {
                    $query .= "$param->key";
                } else if (!StringUtils::isNullOrEmpty($composedValue)) {
                    $query .= "$composedValue";
                } else {
                    $query .= "";
                }

                $query = "$this->operator"."$break".$query.$break;
            }
            break;
            case  Operator::in:
            case  Operator::not_in:
                    $query = "$this->operator".$break;
            case  Operator::tuple:
                $query .= "(";
                $sortParams = ArrayUtils::sort($this->params, array("order"));
                for ($i = 0; $i < sizeof($sortParams); $i++) {
                    $param = $sortParams[$i];
                    if ($i>0) {
                        $query .= ",";
                    }

                    $composedValue = QueryPart::getParamValue($param->value);
                    if (!StringUtils::isNullOrEmpty($param->key)) {
                        $query .= "$param->key";
                    } else if (!StringUtils::isNullOrEmpty($composedValue)) {
                        $query .= "$composedValue";
                    } else {
                        $query .= "";
                    }
                }

                $query .= ")".$break;
                break;
            case  Operator::all:
                $query = "*".$break;
                break;
            default:
                // Log not support
                return false;
        }

        $query = "$this->keyword".$query;
        var_dump($query);
        return $query;
    }

    public static function getParamValue($param) {
        $composedValue = $param->value->composeQueryPart();
        $composedQuery = $param->value->composeQuery();
        if ($composedValue != null) {
            return $composedValue;
        } else if ($composedQuery != null) {
            return $composedQuery;
        } else {
            return $param->value;
        }
    }
}