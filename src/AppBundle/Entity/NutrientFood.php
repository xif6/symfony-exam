<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NutrientFood
 *
 * @ORM\Table(name="nutrient_food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NutrientFoodRepository")
 */
class NutrientFood
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="nutrientsFood")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     */
    private $food;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Nutrient")
     * @ORM\JoinColumn(name="nutrient_id", referencedColumnName="id")
     */
    private $nutrient;

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
     * Set value
     *
     * @param float $value
     *
     * @return NutrientFood
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set food
     *
     * @param Food $food
     *
     * @return Nutrient
     */
    public function setFood(Food $food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set nutrient
     *
     * @param Nutrient $nutrient
     *
     * @return Nutrient
     */
    public function setNutrient(Nutrient $nutrient)
    {
        $this->nutrient = $nutrient;

        return $this;
    }

    /**
     * Get nutrient
     *
     * @return Nutrient
     */
    public function getNutrient()
    {
        return $this->nutrient;
    }
}

