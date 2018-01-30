<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @return Response
     * @throws \LogicException
     * @Route("/", name="home_index")
     */
    public function indexAction(): Response
    {
        return $this->render('Home/index.html.twig');
    }
}
