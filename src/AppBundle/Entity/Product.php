<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity()
 */
class Product
{
    /**
     * @var int|null $id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\Id()
     */
    protected $id;
    
    /**
     * @var string|null $name
     * @ORM\Column(type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string|null $reference
     * @ORM\Column(type="string", length=255)
     */
    protected $reference;
    
    /**
     * @var float|null $price
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;
    
    /**
     * Get id
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * Get name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * Set name
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get reference
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }
    
    /**
     * Set reference
     * @param string $reference
     * @return Product
     */
    public function setReference(string $reference): Product
    {
        $this->reference = $reference;
        return $this;
    }
    
    /**
     * Get price
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }
    
    /**
     * Set price
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }
}
