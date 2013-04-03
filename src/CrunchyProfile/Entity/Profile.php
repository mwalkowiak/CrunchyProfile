<?php

namespace CrunchyProfile\Entity;

class Profile extends AbstractEntity
{

    // columns related attributes
    protected $id;
    protected $key;
    protected $value;
    protected $userId;
    protected $createdAt;
    protected $updatedAt;
    

    /**
     * Getter for id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter for id
     *
     * @param mixed $id Value to set
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Getter for key
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Setter for key
     *
     * @param mixed $key Value to set
     * @return self
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }


    /**
     * Getter for value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setter for value
     *
     * @param mixed $value Value to set
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Getter for user_id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Setter for user_id
     *
     * @param mixed $userId Value to set
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Getter for createdAt
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Setter for createdAt
     *
     * @param mixed $createdAt Value to set
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Getter for updatedAt
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updatedAt
     *
     * @param mixed $updatedAt Value to set
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}