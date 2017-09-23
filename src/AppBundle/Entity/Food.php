<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Food
 *
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"food"}}
 *     })
 * @ORM\Table(name="food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodRepository")
 */
class Food
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"food"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"food"})
     */
    private $name;

    /**
     * @var FoodGroup
     *
     * @ORM\ManyToOne(targetEntity="FoodGroup", inversedBy="foods")
     * @ORM\JoinColumn(name="food_group_id", referencedColumnName="id")
     * @Groups({"food"})
     */
    private $foodGroup;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NutrientFood", mappedBy="food", cascade={"persist", "remove"})
     * @Groups({"food"})
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
}

