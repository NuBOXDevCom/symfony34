<?php
namespace AppBundle\Twig;

use Symfony\Component\HttpKernel\Kernel;

/**
 * Class SymfonyVersionExtension
 * @package AppBundle\Twig
 */
class SymfonyVersionExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [new \Twig_SimpleFunction('symfony_version', [$this, 'b'])];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'symfony_version_extension';
    }

    /**
     * @return string
     */
    public function b()
    {
        return Kernel::VERSION;
    }
}
