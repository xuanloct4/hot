<?php

namespace Src\Controller\Configuration\Response;

use Src\Controller\Response;
use Src\Entity\Configuration\Configuration;

class ConfigurationResponse extends Response
{
    public $id;
    public $files;
    public $uris;
    public $binary;
    public $strings;
    public $update_order;
    public $type;
    public $scopes;
    public $category;
    public $is_deleted;
    public $is_activated;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct(Configuration $configuration)
    {
        $this->id = $configuration->id;
        $this->files = $configuration->files;
        $this->uris = $configuration->uris;
        $this->binary = $configuration->binary;
        $this->strings = $configuration->strings;
        $this->update_order = $configuration->update_order;
        $this->type = $configuration->type;
        $this->scopes = $configuration->scopes;
        $this->category = $configuration->category;
        $this->is_deleted = $configuration->is_deleted;
        $this->is_activated = $configuration->is_activated;
        $this->created_timestamp = $configuration->created_timestamp;
        $this->last_updated_timestamp = $configuration->last_updated_timestamp;
    }

    public static function toConfigurationResponses(array $configurations)
    {
        $configurationResponses = array();
        for ($i = 0; $i < sizeof($configurations); $i++) {
            $configuration = new ConfigurationResponse($configurations[$i]);
            array_push($configurationResponses, $configuration);
        }

        return $configurationResponses;
    }
}
