<?php

namespace StockHavenBundle\Entity;

/**
 * user
 */
class user
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var bool
     */
    private $isSuperUser;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return user
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param $isSuperUser
     * 
     * @return user
     */
    public function setIsSuperUser($isSuperUser)
    {
        $this->isSuperUser = $isSuperUser;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSuperUser()
    {
        return $this->isSuperUser;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return user
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return user
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return user
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * @var \StockHavenBundle\Entity\notification
     */
    private $notification;


    /**
     * Set notification
     *
     * @param \StockHavenBundle\Entity\notification $notification
     *
     * @return user
     */
    public function setNotification(\StockHavenBundle\Entity\notification $notification = null)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return \StockHavenBundle\Entity\notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return User
     */
    public function createToken()
    {
        $this->setToken(md5($this->name.$this->password.microtime()));
        return $this;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}
