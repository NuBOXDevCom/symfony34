<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Cart
 * @package AppBundle\Entity
 */
class Cart
{
    /**
     * @var User $user
     */
    protected $user;
    
    /**
     * @var ArrayCollection $products
     */
    protected $products = [];
    
    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     * @return Cart
     */
    public function setUser(User $user): Cart
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }
    
    /**
     * @param Product $product
     * @param int     $quantity
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        foreach ($this->products as $key => $value) {
            if ($value['product']->getId() === $product->getId()) {
                $this->products[$key] = ['product' => $product, 'quantity' => $value['quantity'] + $quantity];
                return $this;
            }
        }
        $this->products[] = ['product' => $product, 'quantity' => $quantity];
        return $this;
    }
    
    /**
     * @param Product $product
     * @return Cart
     */
    public function removeProduct(Product $product): Cart
    {
        $this->products->removeElement($product);
        return $this;
    }
}
