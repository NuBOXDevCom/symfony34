<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderInvoice
 * @package AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity()
 */
class OrderInvoice
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
     * @ORM\Column(type="string", length=120)
     */
    protected $paymentId;
    
    /**
     * @var float $amount
     * @ORM\Column(type="float", scale=2)
     */
    protected $amount;
    
    /**
     * @var int $invoice
     * @ORM\Column(type="bigint")
     */
    protected $invoiceNumber;
    
    /**
     * @var string $status
     * @ORM\Column(type="string", length=120)
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
     * @ORM\Column(type="string", length=50)
     */
    protected $payerId;
    
    /**
     * @var string $platform
     * @ORM\Column(type="string", length=50)
     */
    protected $gateway;
    
    /**
     * @var ArrayCollection $products
     * @ORM\Column(type="array")
     */
    protected $products;
    
    /**
     * OrderInvoice constructor.
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
     * @return OrderInvoice
     */
    public function setPaymentId(string $paymentId): OrderInvoice
    {
        $this->paymentId = $paymentId;
        return $this;
    }
    
    /**
     * Get amount
     * @return float
     */
    public function getAmount(): float
    {
        return (float)$this->amount;
    }
    
    /**
     * Set amount
     * @param float $amount
     * @return OrderInvoice
     */
    public function setAmount(float $amount): OrderInvoice
    {
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * Get invoiceNumber
     * @return int
     */
    public function getInvoiceNumber(): int
    {
        return $this->invoiceNumber;
    }
    
    /**
     * Set invoiceNumber
     * @param int $invoiceNumber
     * @return OrderInvoice
     */
    public function setInvoiceNumber(int $invoiceNumber): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setStatus(string $status): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setCreated(DateTime $created): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setPayerId(string $payerId): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setGateway(string $gateway): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setUser(User $user): OrderInvoice
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
     * @return OrderInvoice
     */
    public function setProducts(ArrayCollection $products): OrderInvoice
    {
        $this->products = serialize($products);
        return $this;
    }
}
