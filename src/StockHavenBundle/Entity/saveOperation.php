<?php

namespace StockHavenBundle\Entity;

/**
 * saveOperation
 */
class saveOperation
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $modificationDate;

    /**
     * @var operation
     */
    private $operationId;

    /**
     * @var stock
     */
    private $stockId;

    /**
     * @var item
     */
    private $itemId;


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
     * Set modificationDate
     *
     * @param \DateTime $modificationDate
     *
     * @return saveOperation
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set operationId
     *
     * @param operation $operationId
     *
     * @return saveOperation
     */
    public function setOperationId($operationId)
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * Get operationId
     *
     * @return operation
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * Set stockId
     *
     * @param stock $stockId
     *
     * @return saveOperation
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
     * Set itemId
     *
     * @param item $itemId
     *
     * @return saveOperation
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
}
