<?php

namespace StockHavenBundle\Entity;

/**
 * stock
 */
class stock
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
     * @var bool
     */
    private $isDelete;

    /**
     * @var int
     */
    private $userCreatorId;

    /**
     * @var int
     */
    private $barcodeId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $items;


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
     * Set name
     *
     * @param string $name
     *
     * @return stock
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
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return stock
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return bool
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set userCreatorId
     *
     * @param integer $userCreatorId
     *
     * @return stock
     */
    public function setUserCreatorId($userCreatorId)
    {
        $this->userCreatorId = $userCreatorId;

        return $this;
    }

    /**
     * Get userCreatorId
     *
     * @return int
     */
    public function getUserCreatorId()
    {
        return $this->userCreatorId;
    }

    /**
     * Set barcodeId
     *
     * @param integer $barcodeId
     *
     * @return stock
     */
    public function setBarcodeId($barcodeId)
    {
        $this->barcodeId = $barcodeId;

        return $this;
    }

    /**
     * Get barcodeId
     *
     * @return int
     */
    public function getBarcodeId()
    {
        return $this->barcodeId;
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
     * @return stock
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \StockHavenBundle\Entity\user $user
     *
     * @return stock
     */
    public function addUser(\StockHavenBundle\Entity\user $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \StockHavenBundle\Entity\user $user
     */
    public function removeUser(\StockHavenBundle\Entity\user $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add user
     *
     * @param \StockHavenBundle\Entity\item $item
     *
     * @return stock
     */
    public function addItems($item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \StockHavenBundle\Entity\item $item
     */
    public function removeItems($item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
