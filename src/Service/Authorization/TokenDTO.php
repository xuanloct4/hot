<?php

namespace Src\Service\Authorization;


use Src\Entity\Authorization\Token;

class TokenDTO
{
    private $id;
    private $authorized_id;
    private $token;
    private $expired_interval;

    public function __construct(Token $token)
    {
        $this->id = $token->id;
        $this->authorized_id = $token->authorized_id;
        $this->token = $token->token;
        $this->expired_interval = $token->expired_interval;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
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