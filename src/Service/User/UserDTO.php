<?php

namespace Src\Service\User;


use Src\Entity\User\Device;
use Src\Entity\User\User;

class UserDTO
{
    public $id;
    public $name;
    public $address;
    public $location;
    public $phone;
    public $gender;
    public $status;
    public $authorized_id;
    public $preferences;
    public $scopes;
    public $user_device_id;
    public $board_id;
    public $is_activated;
    public $is_deleted;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->address = $user->address;
        $this->location = $user->location;
        $this->phone = $user->phone;
        $this->gender = $user->gender;
        $this->status = $user->status;
        $this->authorized_id = $user->authorized_id;
        $this->preferences = $user->preferences;
        $this->scopes = $user->scopes;
        $this->user_device_id = $user->user_device_id;
        $this->board_id = $user->board_id;
        $this->is_activated = $user->is_activated;
        $this->is_deleted = $user->is_deleted;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
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
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * @param mixed $preferences
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
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
