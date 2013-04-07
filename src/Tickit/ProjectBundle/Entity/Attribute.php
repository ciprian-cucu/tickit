<?php

namespace Tickit\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The Attribute entity represents a specific attribute that is customisable per project
 *
 * @package Tickit\ProjectBundle\Entity
 * @author  James Halsall <james.t.halsall@googlemail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="project_attributes")
 */
class Attribute implements AttributeInterface
{
    const TYPE_TEXT = 'text';
    const TYPE_CHOICE = 'choice';
    const TYPE_ENTITY = 'entity';

    /**
     * The unique identifier for this attribute
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The name of this attribute
     *
     * @ORM\Column(type="string", length=120)
     */
    protected $name;

    /**
     * The default value for this attribute
     *
     * @ORM\Column(name="default_value", type="string", length=500)
     */
    protected $defaultValue;

    /**
     * Boolean indicating whether this attribute can be left empty
     *
     * @var boolean
     * @ORM\Column(name="allow_blank", type="boolean")
     */
    protected $allowBlank;

    /**
     * JSON encoded meta data for the attribute
     *
     * @var string
     */
    protected $metaDeta;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->allowBlank = true;
        $this->metaDeta = json_encode(array());
    }

    /**
     * Gets the attribute ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name of this attribute
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the name of this attribute
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the default value for this attribute
     *
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Gets the default value for this attribute
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Sets whether blank values are allowed on this attribute
     *
     * @param boolean $allowBlank
     */
    public function setAllowBlank($allowBlank)
    {
        $this->allowBlank = $allowBlank;
    }

    /**
     * Returns true if this attribute can have a blank value, false otherwise
     *
     * @return boolean
     */
    public function allowBlank()
    {
        return $this->allowBlank;
    }

    /**
     * Sets metadata on this attribute.
     *
     * The data should be json_encoded
     *
     * @param string $metaDeta
     *
     * @throws \InvalidArgumentException If the given meta data isn't json encoded
     *
     * @return Attribute
     */
    public function setMetaDeta($metaDeta)
    {
        if (null === json_decode($metaDeta)) {
            throw new \InvalidArgumentException('Invalid meta data provided');
        }
        $this->metaDeta = $metaDeta;
    }

    /**
     * Gets meta data for this attribute
     *
     * @param boolean $decode True to decode the metadata before returning, defaults to false
     *
     * @return mixed
     */
    public function getMetaDeta($decode = false)
    {
        if (true !== $decode) {
            return $this->metaDeta;
        }

        return json_decode($this->metaDeta);
    }
}