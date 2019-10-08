<?php

namespace Src\Service\Authorization;


use Src\Entity\Authorization\Authorization;
use Src\Service\DTO;

class AuthorizationDTO extends DTO
{
    private $id;
    private $name;
    private $uuid;
    private $authorized_code;
    private $tokens;
    private $expired_interval;

    public function __construct(Authorization $authorization)
    {
        $this->id = $authorization->id;
        $this->name = $authorization->name;
        $this->uuid = $authorization->uuid;
        $this->authorized_code = $authorization->authorized_code;
        $this->tokens = $authorization->tokens;
        $this->expired_interval = $authorization->expired_interval;
    }

    public function toArray()
    {
        return array("id" => $this->id,
            "name" => $this->name,
            "uuid" => $this->uuid,
            "authorized_code" => $this->authorized_code,
            "tokens" => $this->tokens,
            "expired_interval" => $this->expired_interval);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getAuthorizedCode()
    {
        return $this->authorized_code;
    }

    /**
     * @param mixed $authorized_code
     */
    public function setAuthorizedCode($authorized_code)
    {
        $this->authorized_code = $authorized_code;
    }

    /**
     * @return mixed
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param mixed $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return mixed
     */
    public function getExpiredInterval()
    {
        return $this->expired_interval;
    }

    /**
     * @param mixed $expired_interval
     */
    public function setExpiredInterval($expired_interval)
    {
        $this->expired_interval = $expired_interval;
    }
}