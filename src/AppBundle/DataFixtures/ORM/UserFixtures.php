<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function load(ObjectManager $manager): void
    {
        $encoder = $this->container->get('security.password_encoder');
        
        $user = new User();
        $user->setUsername('admin')->setEmail('admin@website.net')->setEnabled(true)->setSuperAdmin(true);
        $user->setPassword($encoder->encodePassword($user, 'admin'));
        $manager->persist($user);
        
        $user = new User();
        $user->setUsername('user')->setEmail('user@website.net')->setEnabled(true)->setRoles(['ROLE_USER']);
        $user->setPassword($encoder->encodePassword($user, 'user'));
        $manager->persist($user);
        
        $manager->flush();
    }
    
    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
