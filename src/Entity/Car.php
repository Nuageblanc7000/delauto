<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(
     *   message="veuillez compléter le champ"
     * )
     * @Assert\PositiveOrZero(
     *  message="veuillez insérer un chiffre possitive"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message="veuillez compléter le champ"
     * )
     * @Assert\PositiveOrZero(
     *      message="veuillez ajouter un nombre"
     * )
     * 
     */
    private $km;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(
     *     message="veuillez compléter le champ"
     * )
     * @Assert\PositiveOrZero(
     *  message="veuillez ajouter un nombre"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero(
     *     message="veuillez introduire une valeur positive ou zéro"
     * )
     * @Assert\NotBlank(
     *     message="veuillez introduire une valeur"
     * )
     */
    private $numberOwners;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Positive(
     *  message="veuillez insérer un chiffre supérieur à zéro exemple 1500"
     * )
     * @Assert\NotBlank(
     *    message="veuillez introduire une valeur"
     * )
     */
    private $enginesize;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("datetime")
     * 
     */
    private $yearOfEntry;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(
     *  message="veuillez insérer une valeur (diesel)"
     * )
     * @Assert\Choice(
     *  {"diesel","essence","électrique","LPG"},
     *  message="la valeur choisie n'existe pas"
     * )
     * 
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $transmission;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min=20,
     *      minMessage="Veuillez insérer au minumum {{ limit }} caractère"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $options;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Url(message="veuillez insérer une url correcte")
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=160)
     * @Assert\NotBlank(
     *      message="veuillez insérer une valeur"
     * )
     * @Assert\Positive(
     *      message="veuillez insérer un chiffre supérieur à zéro exemple 180"
     * )
     */
    private $powerEngine;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="car", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="car")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mark;
    
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }
    

        /**
         * slug automatique si il est vide
         * @ORM\PrePersist
         * @ORM\PreUpdate
         * 
         * @return void
         */
    public function autoSlug(){
        if(empty($this->slug)){
        $slugify = new Slugify();
         $this->slug = $slugify->slugify($this->model.' '.uniqid('id',false));
        }
    }
    /**
     * permet d'obtenir un tableau mappable (voir dans twig showCar)
     *
     * @return Array
     */
    public function GetExplodeString(){
        return explode(',',$this->getOptions());
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNumberOwners(): ?int
    {
        return $this->numberOwners;
    }

    public function setNumberOwners(?int $numberOwners): self
    {
        $this->numberOwners = $numberOwners;

        return $this;
    }

    public function getEnginesize(): ?string
    {
        return $this->enginesize;
    }

    public function setEnginesize(string $enginesize): self
    {
        $this->enginesize = $enginesize;

        return $this;
    }

    public function getYearOfEntry(): ?\DateTimeInterface
    {
        return $this->yearOfEntry;
    }

    public function setYearOfEntry(\DateTimeInterface $yearOfEntry): self
    {
        $this->yearOfEntry = $yearOfEntry;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPowerEngine(): ?string
    {
        return $this->powerEngine;
    }

    public function setPowerEngine(string $powerEngine): self
    {
        $this->powerEngine = $powerEngine;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCar() === $this) {
                $image->setCar(null);
            }
        }

        return $this;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }
}
