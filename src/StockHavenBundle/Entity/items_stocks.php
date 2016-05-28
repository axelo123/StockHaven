<?php

namespace StockHavenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * items_stocks
 */
class items_stocks
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var item
     */
    private $itemId;

    /**
     * @var stock
     */
    private $stockId;

    /**
     * @var integer
     */
    private $quantity;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itemId
     *
     * @param item $itemId
     * @return items_stocks
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return item 
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set stockId
     *
     * @param stock $stockId
     * @return items_stocks
     */
    public function setStockId($stockId)
    {
        $this->stockId = $stockId;

        return $this;
    }

    /**
     * Get stockId
     *
     * @return stock 
     */
    public function getStockId()
    {
        return $this->stockId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return items_stocks
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
