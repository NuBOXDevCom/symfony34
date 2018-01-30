<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int $id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @var string $paymentId
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $paymentId;
    
    /**
     * @var float $amount
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $amount;
    
    /**
     * @var int $invoice
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $invoiceNumber;
    
    /**
     * @var string $status
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $status;
    
    /**
     * @var DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;
    
    /**
     * @var string $payerId
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $payerId;
    
    /**
     * @var string $platform
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $gateway;
    
    /**
     * @var ArrayCollection $products
     * @ORM\Column(type="array")
     */
    protected $products = [];
    
    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->setCreated(new DateTime());
        $this->products = new ArrayCollection();
    }
    
    /**
     * Get id
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * Get paymentId
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }
    
    /**
     * Set paymentId
     * @param string $paymentId
     * @return Order
     */
    public function setPaymentId(string $paymentId): Order
    {
        $this->paymentId = $paymentId;
        return $this;
    }
    
    /**
     * Get amount
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }
    
    /**
     * Set amount
     * @param float $amount
     * @return Order
     */
    public function setAmount(float $amount): Order
    {
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * Get invoiceNumber
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }
    
    /**
     * Set invoiceNumber
     * @param int $invoiceNumber
     * @return Order
     */
    public function setInvoiceNumber(int $invoiceNumber): Order
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }
    
    /**
     * Get status
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
    
    /**
     * Set status
     * @param string $status
     * @return Order
     */
    public function setStatus(string $status): Order
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Get created
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }
    
    /**
     * Set created
     * @param DateTime $created
     * @return Order
     */
    public function setCreated(DateTime $created): Order
    {
        $this->created = $created;
        return $this;
    }
    
    /**
     * Get payerId
     * @return string
     */
    public function getPayerId(): string
    {
        return $this->payerId;
    }
    
    /**
     * Set payerId
     * @param string $payerId
     * @return Order
     */
    public function setPayerId(string $payerId): Order
    {
        $this->payerId = $payerId;
        return $this;
    }
    
    /**
     * Get gateway
     * @return string
     */
    public function getGateway(): string
    {
        return $this->gateway;
    }
    
    /**
     * Set gateway
     * @param string $gateway
     * @return Order
     */
    public function setGateway($gateway): Order
    {
        $this->gateway = $gateway;
        return $this;
    }
    
    /**
     * Get user
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * Set user
     * @param User $user
     * @return Order
     */
    public function setUser(User $user): Order
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Get products
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return unserialize($this->products, ['allowed_classes' => true]);
    }
    
    /**
     * Set products
     * @param ArrayCollection $products
     * @return Order
     */
    public function setProducts(ArrayCollection $products): Order
    {
        $this->products = serialize($products);
        return $this;
    }
}
