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
     * @var string
     */
    private $element_name;

    /**
     * @var string
     */
    private $type_element;
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
     * Set element_name
     *
     * @param string $element_name
     *
     * @return saveOperation
     */
    public function setElementName($element_name)
    {
        $this->element_name = $element_name;

        return $this;
    }

    /**
     * Get element_name
     *
     * @return string
     */
    public function getElementName()
    {
        return $this->element_name;
    }

    /**
     * @param $type_element
     * @return $this
     */
    public function setTypeElement($type_element)
    {
        $this->type_element = $type_element;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeElement()
    {
        return $this->type_element;
    }
}
