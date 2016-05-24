<?php

namespace StockHavenBundle\Entity;

/**
 * barcode
 */
class barcode
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $barcode;


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
     * Set barcode
     *
     * @param string $barcode
     *
     * @return barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }
}
