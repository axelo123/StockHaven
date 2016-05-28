<?php

namespace StockHavenBundle\Entity;

/**
 * store
 */
class store
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
     * @var string
     */
    private $picture;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $items;

    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return store
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
     * Set picture
     *
     * @param string $picture
     *
     * @return store
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Add store
     *
     * @param item $item
     *
     * @return item
     */
    public function addItem(item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove store
     *
     * @param item $item
     */
    public function removeItem(item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
