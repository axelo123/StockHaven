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
     * @var int
     */
    private $operationId;

    /**
     * @var int
     */
    private $stockId;

    /**
     * @var int
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
     * @param integer $operationId
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
     * @return int
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * Set stockId
     *
     * @param integer $stockId
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
     * @return int
     */
    public function getStockId()
    {
        return $this->stockId;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
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
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }
}
