<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderInvoice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package AppBundle\Controller
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \LogicException
     * @Route("/orders", name="orders_index")
     * @throws \UnexpectedValueException
     */
    public function indexUserAction(Request $request): Response
    {
        $em         = $this->getDoctrine()->getManager();
        $orders     = $em->getRepository(OrderInvoice::class)->findBy([
            'user' => $this->getUser()
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($orders, $request->query->getInt('p', 1));
        return $this->render(':Order:indexUser.html.twig', [
            'pagination' => $pagination,
            'locale'     => $request->getLocale()
        ]);
    }
    
    /**
     * @param Request $request
     * @param    int  $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @Route("/orders/invoice/{id}", name="order_invoice", requirements={"id"="\d+"})
     */
    public function invoiceAction(Request $request, int $id)
    {
        $em    = $this->getDoctrine()->getManager();
        $order = $em->getRepository(OrderInvoice::class)->find($id);
        if ($order && $order->getUser()->getId() === $this->getUser()->getId()) {
            $html     = $this->renderView(':Order:invoice.html.twig', [
                'order'  => $order,
                'user'   => $this->getUser(),
                'locale' => $request->getLocale()
            ]);
            $filename = sprintf('invoice-%s.pdf', $order->getInvoiceNumber());
            return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]);
        }
        return $this->redirectToRoute('orders_index');
    }
}
