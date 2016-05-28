<?php

namespace StockHavenBundle\Entity;

/**
 * notification
 */
class notification
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var user
     */
    private $userId;

    /**
     * @var bool
     */
    private $isValided;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var stock
     */
    private $stockId;

    /**
     * @var bool
     */
    private $isView;


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
     * Set userId
     *
     * @param user $userId
     *
     * @return notification
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return user
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set isValided
     *
     * @param boolean $isValided
     *
     * @return notification
     */
    public function setIsValided($isValided)
    {
        $this->isValided = $isValided;

        return $this;
    }

    /**
     * Get isValided
     *
     * @return bool
     */
    public function getIsValided()
    {
        return $this->isValided;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return notification
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set stockId
     *
     * @param stock $stockId
     *
     * @return notification
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
     * Set isView
     *
     * @param boolean $isView
     *
     * @return notification
     */
    public function setIsView($isView)
    {
        $this->isView = $isView;

        return $this;
    }

    /**
     * Get isView
     *
     * @return bool
     */
    public function getIsView()
    {
        return $this->isView;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stockId = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userId = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stockId
     *
     * @param stock $stockId
     *
     * @return notification
     */
    public function addStockId(stock $stockId)
    {
        $this->stockId[] = $stockId;

        return $this;
    }

    /**
     * Remove stockId
     *
     * @param stock $stockId
     */
    public function removeStockId(stock $stockId)
    {
        $this->stockId->removeElement($stockId);
    }

    /**
     * Add userId
     *
     * @param user $userId
     *
     * @return notification
     */
    public function addUserId(user $userId)
    {
        $this->userId[] = $userId;

        return $this;
    }

    /**
     * Remove userId
     *
     * @param user $userId
     */
    public function removeUserId(user $userId)
    {
        $this->userId->removeElement($userId);
    }
}
