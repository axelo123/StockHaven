<?php

namespace StockHavenBundle\Entity;

/**
 * address
 */
class address
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $nbBox;

    /**
     * @var string
     */
    private $street;

    /**
     * @var int
     */
    private $postalCodeId;

    /**
     * @var int
     */
    private $storeId;


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
     * Set nbBox
     *
     * @param integer $nbBox
     *
     * @return address
     */
    public function setNbBox($nbBox)
    {
        $this->nbBox = $nbBox;

        return $this;
    }

    /**
     * Get nbBox
     *
     * @return int
     */
    public function getNbBox()
    {
        return $this->nbBox;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postalCodeId
     *
     * @param integer $postalCodeId
     *
     * @return address
     */
    public function setPostalCodeId($postalCodeId)
    {
        $this->postalCodeId = $postalCodeId;

        return $this;
    }

    /**
     * Get postalCodeId
     *
     * @return int
     */
    public function getPostalCodeId()
    {
        return $this->postalCodeId;
    }

    /**
     * Set storeId
     *
     * @param integer $storeId
     *
     * @return address
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Get storeId
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
