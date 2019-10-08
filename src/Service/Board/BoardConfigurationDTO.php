<?php

namespace Src\Service\Board;


use Src\Entity\Board\BoardConfiguration;
use Src\Service\DTO;

class BoardConfigurationDTO extends DTO
{
    private $id;
    private $board_id;
    private $server_configuration_id;
    private $user_device_id;
    private $user_id;
    private $topos;
    private $status;
    private $authorized_id;
    private $configuration;
    private $scopes;
    private $is_activated;
    private $is_deleted;

    /**
     * BoardConfigurationDTO constructor.
     */
    public function __construct(BoardConfiguration $boardConfiguration)
    {
        $this->id = $boardConfiguration->id;
        $this->board_id = $boardConfiguration->board_id;
        $this->server_configuration_id = $boardConfiguration->server_configuration_id;
        $this->user_device_id = $boardConfiguration->user_device_id;
        $this->user_id = $boardConfiguration->user_id;
        $this->topos = $boardConfiguration->topos;
        $this->status = $boardConfiguration->status;
        $this->authorized_id = $boardConfiguration->authorized_id;
        $this->configuration = $boardConfiguration->configuration;
        $this->scopes = $boardConfiguration->scopes;
        $this->is_activated = $boardConfiguration->is_activated;
        $this->is_deleted = $boardConfiguration->is_deleted;
    }

    public function toArray() {
        return array("id" => $this->id,
            "board_id" => $this->board_id,
            "server_configuration_id" => $this->server_configuration_id,
            "user_device_id" => $this->user_device_id,
            "user_id" => $this->user_id,
            "topos" => $this->topos,
            "status" => $this->status,
            "authorized_id" => $this->authorized_id,
            "configuration" => $this->configuration,
            "scopes" => $this->scopes,
            "is_activated" => $this->is_activated,
            "is_deleted" => $this->is_deleted);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBoardId()
    {
        return $this->board_id;
    }

    /**
     * @param mixed $board_id
     */
    public function setBoardId($board_id)
    {
        $this->board_id = $board_id;
    }

    /**
     * @return mixed
     */
    public function getServerConfigurationId()
    {
        return $this->server_configuration_id;
    }

    /**
     * @param mixed $server_configuration_id
     */
    public function setServerConfigurationId($server_configuration_id)
    {
        $this->server_configuration_id = $server_configuration_id;
    }

    /**
     * @return mixed
     */
    public function getUserDeviceId()
    {
        return $this->user_device_id;
    }

    /**
     * @param mixed $user_device_id
     */
    public function setUserDeviceId($user_device_id)
    {
        $this->user_device_id = $user_device_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getTopos()
    {
        return $this->topos;
    }

    /**
     * @param mixed $topos
     */
    public function setTopos($topos)
    {
        $this->topos = $topos;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAuthorizedId()
    {
        return $this->authorized_id;
    }

    /**
     * @param mixed $authorized_id
     */
    public function setAuthorizedId($authorized_id)
    {
        $this->authorized_id = $authorized_id;
    }

    /**
     * @return mixed
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param mixed $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @return mixed
     */
    public function getisActivated()
    {
        return $this->is_activated;
    }

    /**
     * @param mixed $is_activated
     */
    public function setIsActivated($is_activated)
    {
        $this->is_activated = $is_activated;
    }

    /**
     * @return mixed
     */
    public function getisDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }


}