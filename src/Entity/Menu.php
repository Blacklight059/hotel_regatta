<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: Starter::class, inversedBy: 'menus')]
    private Collection $starter;

    #[ORM\ManyToMany(targetEntity: Dish::class, inversedBy: 'menus')]
    private Collection $dish;

    #[ORM\ManyToMany(targetEntity: Dessert::class, inversedBy: 'menus')]
    private Collection $dessert;

    public function __construct()
    {
        $this->starter = new ArrayCollection();
        $this->dish = new ArrayCollection();
        $this->dessert = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Starter>
     */
    public function getStarter(): Collection
    {
        return $this->starter;
    }

    public function addStarter(Starter $starter): static
    {
        if (!$this->starter->contains($starter)) {
            $this->starter->add($starter);
        }

        return $this;
    }

    public function removeStarter(Starter $starter): static
    {
        $this->starter->removeElement($starter);

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDish(): Collection
    {
        return $this->dish;
    }

    public function addDish(Dish $dish): static
    {
        if (!$this->dish->contains($dish)) {
            $this->dish->add($dish);
        }

        return $this;
    }

    public function removeDish(Dish $dish): static
    {
        $this->dish->removeElement($dish);

        return $this;
    }

    /**
     * @return Collection<int, Dessert>
     */
    public function getDessert(): Collection
    {
        return $this->dessert;
    }

    public function addDessert(Dessert $dessert): static
    {
        if (!$this->dessert->contains($dessert)) {
            $this->dessert->add($dessert);
        }

        return $this;
    }

    public function removeDessert(Dessert $dessert): static
    {
        $this->dessert->removeElement($dessert);

        return $this;
    }
}
