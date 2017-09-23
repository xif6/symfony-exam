<?php

namespace AppBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FoodGroup
 *
 * @ORM\Table(name="food_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodGroupRepository")
 */
class FoodGroup
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Groups({"food"})
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Food", mappedBy="foodGroup")
     */
    private $foods;

    /**
     * FoodGroup constructor.
     */
    public function __construct() {
        $this->foods = new ArrayCollection();
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
     * @return FoodGroup
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
     * Add food
     *
     * @param Food $food
     * @return FoodGroup
     */
    public function addFood(Food $food)
    {
        $this->foods[] = $food;
        return $this;
    }

    /**
     * Remove food
     *
     * @param Food $food
     */
    public function removeFood(Food $food)
    {
        $this->foods->removeElement($food);
    }

    /**
     * Get food
     *
     * @return ArrayCollection
     */
    public function getFoods()
    {
        return $this->foods;
    }
}

