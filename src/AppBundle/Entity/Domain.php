<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Domain
 * @package AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DomainRepository")
 */
class Domain
{
    /**
     * Identifiant unique du domaine
     * @var int|null
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * Nom de domaine (host.name.net)
     * @var string|null $name
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $name;
    
    /**
     * @var User|null $user
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * Date à laquelle le domaine a été enregistré
     * @var DateTime|null $created
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * Retourne le statut du domaine (1 = Activé, 0 = Désactivé)
     * @var boolean|null $enabled
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;
    
    /**
     * Domain constructor.
     */
    public function __construct()
    {
        $this->created = new DateTime();
    }
    
    /**
     * Get id
     * @return int|null
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
     * @return Domain
     */
    public function setName(string $name): Domain
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get user
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    /**
     * Set user
     * @param User $user
     * @return Domain
     */
    public function setUser(User $user): Domain
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Get created
     * @return DateTime|null
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }
    
    /**
     * Set created
     * @param DateTime $created
     * @return Domain
     */
    public function setCreated(DateTime $created): Domain
    {
        $this->created = $created;
        return $this;
    }
    
    /**
     * Get enabled
     * @return boolean|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }
    
    /**
     * Set enabled
     * @param boolean $enabled
     * @return Domain
     */
    public function setEnabled(bool $enabled): Domain
    {
        $this->enabled = $enabled;
        return $this;
    }
}
