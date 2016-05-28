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
     * @var user
     */
    private $userCreatorId;

    /**
     * @var barcode
     */
    private $barcodeId;

    /**
     * @var items_stocks
     */
    private $itemsStocks;


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
     * @param user $userCreatorId
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
     * @return user
     */
    public function getUserCreatorId()
    {
        return $this->userCreatorId;
    }

    /**
     * Set barcodeId
     *
     * @param barcode $barcodeId
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
     * @return barcode
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
        $this->itemsStocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param user $user
     *
     * @return stock
     */
    public function addUser(user $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param user $user
     */
    public function removeUser(user $user)
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
     * Set itemsStocks
     *
     * @param items_stocks $itemsStocks
     * @return item
     */
    public function setItemsStocks(items_stocks $itemsStocks)
    {
        $this->itemsStocks = $itemsStocks;

        return $this;
    }

    /**
     * Get itemsStocks
     *
     * @return items_stocks
     */
    public function getStocksItems()
    {
        return $this->itemsStocks;
    }

    /**
     * Add itemsStocks
     *
     * @param  $itemsStocks
     * @return item
     */
    public function addStockItem(items_stocks $itemsStocks)
    {

        $itemsStocks->setStockId($this);
        $this->itemsStocks[] = $itemsStocks;

        return $this;
    }

    /**
     * Remove itemsStocks
     *
     * @param  $itemsStocks
     */
    public function removeStocksItems(items_stocks $itemsStocks)
    {
        $this->itemsStocks->removeElement($itemsStocks);
    }


    /**
     * Add itemsStocks
     *
     * @param \StockHavenBundle\Entity\items_stocks $itemsStocks
     * @return stock
     */
    public function addItemsStock(\StockHavenBundle\Entity\items_stocks $itemsStocks)
    {
        $this->itemsStocks[] = $itemsStocks;

        return $this;
    }

    /**
     * Remove itemsStocks
     *
     * @param \StockHavenBundle\Entity\items_stocks $itemsStocks
     */
    public function removeItemsStock(\StockHavenBundle\Entity\items_stocks $itemsStocks)
    {
        $this->itemsStocks->removeElement($itemsStocks);
    }

    /**
     * Get itemsStocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItemsStocks()
    {
        return $this->itemsStocks;
    }
}
