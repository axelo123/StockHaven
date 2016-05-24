<?php

namespace StockHavenBundle\Entity;

/**
 * item
 */
class item 
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
     * @var int
     */
    private $quantity;

    /**
     * @var bool
     */
    private $isDelete;

    /**
     * @var int
     */
    private $countUpdate;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $typeId;

    /**
     * @var int
     */
    private $currencyId;

    /**
     * @var int
     */
    private $barcodeId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $stores;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $stocks;
    

    public function __construct() {
        $this->stores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return item
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return item
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
     * Set countUpdate
     *
     * @param integer $countUpdate
     *
     * @return item
     */
    public function setCountUpdate($countUpdate)
    {
        $this->countUpdate = $countUpdate;

        return $this;
    }

    /**
     * Get countUpdate
     *
     * @return int
     */
    public function getCountUpdate()
    {
        return $this->countUpdate;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return item
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     *
     * @return item
     */
    public function setCurrencyId($currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return int
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set barcodeId
     *
     * @param integer $barcodeId
     *
     * @return item
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
     * Add store
     *
     * @param \StockHavenBundle\Entity\store $store
     *
     * @return item
     */
    public function addStore(\StockHavenBundle\Entity\store $store)
    {
        $this->stores[] = $store;

        return $this;
    }

    /**
     * Remove store
     *
     * @param \StockHavenBundle\Entity\store $store
     */
    public function removeStore(\StockHavenBundle\Entity\store $store)
    {
        $this->stores->removeElement($store);
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Add store
     *
     * @param \StockHavenBundle\Entity\stock $stock
     *
     * @return item
     */
    public function addStock($stock)
    {
        $this->stocks[] = $stock;

        return $this;
    }

    /**
     * Remove store
     *
     * @param \StockHavenBundle\Entity\stock $stock
     */
    public function removeStock($stock)
    {
        $this->stocks->removeElement($stock);
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStocks()
    {
        return $this->stocks;
    }
}
