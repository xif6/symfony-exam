<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Food
 *
 * @ORM\Table(name="food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodRepository")
 */
class Food implements \JsonSerializable
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var FoodGroup
     *
     * @ORM\ManyToOne(targetEntity="FoodGroup", inversedBy="foods")
     * @ORM\JoinColumn(name="food_group_id", referencedColumnName="id")
     */
    private $foodGroup;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NutrientFood", mappedBy="food", cascade={"persist", "remove"})
     */
    private $nutrientsFood;

    /**
     * Food constructor.
     */
    public function __construct() {
        $this->nutrientsFood = new ArrayCollection();
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
     * @return Food
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
     * Set foodGroup
     *
     * @param FoodGroup $foodGroup
     *
     * @return Food
     */
    public function setFoodGroup(FoodGroup $foodGroup)
    {
        $this->foodGroup = $foodGroup;

        return $this;
    }

    /**
     * Get foodGroup
     *
     * @return FoodGroup
     */
    public function getFoodGroup()
    {
        return $this->foodGroup;
    }

    /**
     * Add nutrientsFood
     *
     * @param NutrientFood $nutrientFood
     * @return Food
     */
    public function addNutrientFood(NutrientFood $nutrientFood)
    {
        $this->nutrientsFood[] = $nutrientFood;
        return $this;
    }

    /**
     * Remove nutrientFood
     *
     * @param NutrientFood $nutrientFood
     */
    public function removeNutrientFood(NutrientFood $nutrientFood)
    {
        $this->nutrientsFood->removeElement($nutrientFood);
    }

    /**
     * Get nutrientsFood
     *
     * @return ArrayCollection
     */
    public function getNutrientsFood()
    {
        return $this->nutrientsFood;
    }

    public function jsonSerialize()
    {
        return ['id' => $this->getId(), 'name' => $this->getName(), 'group' => $this->getFoodGroup()->getName()];
    }
}

