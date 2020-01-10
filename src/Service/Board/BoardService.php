<?php

namespace Src\Service\Board;

use Src\Service\DBService;
use Src\System\Configuration;
use Src\Entity\Board\Board;

class BoardService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BoardService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Board();
    }


    // CRUD
}
