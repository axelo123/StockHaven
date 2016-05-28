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
     * @var type
     */
    private $typeId;

    /**
     * @var currency
     */
    private $currencyId;

    /**
     * @var barcode
     */
    private $barcodeId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $stores;

    /**
     * @var items_stocks
     */
    private $itemsStocks;
    

    public function __construct() {
        $this->stores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->itemsStocks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param type $typeId
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
     * @return type
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set currencyId
     *
     * @param currency $currencyId
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
     * @return currency
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set barcodeId
     *
     * @param barcode $barcodeId
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
     * @return barcode
     */
    public function getBarcodeId()
    {
        return $this->barcodeId;
    }

    /**
     * Add store
     *
     * @param store $store
     *
     * @return item
     */
    public function addStore(store $store)
    {
        $this->stores[] = $store;

        return $this;
    }

    /**
     * Remove store
     *
     * @param store $store
     */
    public function removeStore(store $store)
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
    public function getItemsStocks()
    {
        return $this->itemsStocks;
    }
    

    /**
     * Add itemsStocks
     *
     * @param  $itemsStocks
     * @return item
     */
    public function addItemsStock(items_stocks $itemsStocks)
    {
        $itemsStocks->setItemId($this);
        $this->itemsStocks[] = $itemsStocks;
        
        return $this;
    }

    /**
     * Remove itemsStocks
     *
     * @param $itemsStocks
     */
    public function removeItemsStock(items_stocks $itemsStocks)
    {
        $this->itemsStocks->removeElement($itemsStocks);
    }
}
