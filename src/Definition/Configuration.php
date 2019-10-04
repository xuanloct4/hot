<?php
namespace Src\Definition;
use MyCLabs\Enum\Enum;

/**
 * Configuration enum
 */
class Configuration extends Enum
{
    const BOARD = 0;
    const USER = 1;
    const USER_DEVICE = 2;
    const SERVER = 3;

    const BOARD_ALIAS = "board";
    const USER_ALIAS = "user";
    const USER_DEVICE_ALIAS = "device";
    const SERVER_ALIAS = "server";

    const BASE_URL_COMPONENT_NUMBER = 3;

    public static function getAlias($config){
        switch ($config) {
            case Configuration::BOARD:
                return Configuration::BOARD_ALIAS;
            case Configuration::USER:
                return Configuration::USER_ALIAS;
            case Configuration::USER_DEVICE:
                return Configuration::USER_DEVICE_ALIAS;
            case Configuration::SERVER:
                return Configuration::SERVER_ALIAS;
        }
        return null;
    }

    public static function getConfiguration($alias){
        switch ($alias) {
            case Configuration::BOARD_ALIAS:
                return Configuration::BOARD;
            case Configuration::USER_ALIAS:
                return Configuration::USER;
            case Configuration::USER_DEVICE_ALIAS:
                return Configuration::USER_DEVICE;
            case Configuration::SERVER_ALIAS:
                return Configuration::SERVER;
        }
        return null;
    }
}