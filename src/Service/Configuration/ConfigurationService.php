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


}
