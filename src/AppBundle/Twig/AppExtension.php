<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Domain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var TokenStorage $user
     */
    protected $user;
    /**
     * @var EntityManagerInterface $em
     */
    protected $em;
    
    /**
     * @var SessionInterface $session
     */
    protected $session;
    
    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface  $tokenStorage
     * @param SessionInterface       $session
     * @internal param ContainerInterface $container
     * @internal param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session
    ) {
        $this->user = $tokenStorage;
        $this->em = $entityManager;
        $this->session = $session;
    }
    
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        if ($this->user->getToken()) {
            return [
                new Twig_SimpleFunction('domains', [$this, 'domainsFunction']),
                new Twig_SimpleFunction('domainsEnabled', [$this, 'domainsEnabledFunction']),
                new Twig_SimpleFunction('ProductsCart', [$this, 'countProductCartFunction'])
            ];
        }
        return [];
    }
    
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [new Twig_SimpleFilter('ucfirst', [$this, 'ucFirstFilter'])];
    }
    
    /**
     * @return null|int
     */
    public function domainsFunction(): ?int
    {
        $user = $this->user->getToken()->getUser();
        return $this->em->getRepository(Domain::class)->countDomainsByUserId($user->getId());
    }
    
    /**
     * @return null|int
     */
    public function domainsEnabledFunction(): ?int
    {
        $user = $this->user->getToken()->getUser();
        return $this->em->getRepository(Domain::class)->countDomainsEnabledByUserId($user->getId());
    }
    
    /**
     * @return int
     */
    public function countProductCartFunction(): int
    {
        $count = 0;
        if ($this->session->has('cart')) {
            foreach ($this->session->get('cart')->getProducts() as $product) {
                $count += $product['quantity'];
            }
        }
        return $count;
    }
    
    /**
     * @param string $string
     * @return string
     */
    public function ucFirstFilter(string $string): string
    {
        return ucfirst($string);
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'app_extension';
    }
}
