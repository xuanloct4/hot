<?php

namespace Src\Service\Categorization;
use Src\Entity\Categorization\Category;
use Src\Service\DBService;

class CategoryService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CategoryService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Category();
    }

    // CRUD
}
