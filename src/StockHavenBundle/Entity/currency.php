<?php

namespace StockHavenBundle\Entity;

/**
 * currency
 */
class currency
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $longName;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @var string
     */
    private $symbol;


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
     * Set longName
     *
     * @param string $longName
     *
     * @return currency
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * Get longName
     *
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Set shortName
     *
     * @param string $shortName
     *
     * @return currency
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     *
     * @return currency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
