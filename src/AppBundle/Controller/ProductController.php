<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package AppBundle\Controller
 */
class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \LogicException
     * @Route("/products", name="products_index")
     */
    public function indexAction(Request $request): Response
    {
        $em         = $this->getDoctrine()->getManager();
        $products   = $em->getRepository(Product::class)->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($products, $request->query->getInt('p', 1));
        return $this->render(':Product:index.html.twig', [
            'pagination' => $pagination,
            'locale'     => $request->getLocale()
        ]);
    }
    
    /**
     * @param Request $request
     * @return RedirectResponse|Response|NotFoundHttpException
     * @throws \LogicException
     * @Route("/products/add", name="product_add")
     */
    public function addAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em      = $this->getDoctrine()->getManager();
            $product = new Product();
            $form    = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($product);
                $em->flush();
                $this->addFlash('success', 'Produit ajouté avec succès');
                return $this->redirectToRoute('products_index');
            }
            return $this->render(':Product:add.html.twig', ['form' => $form->createView()]);
        }
        return $this->createNotFoundException();
    }
    
    /**
     * @param Request $request
     * @param  int    $id
     * @return RedirectResponse|Response|NotFoundHttpException
     * @throws \LogicException
     * @Route("/products/edit/{id}", name="product_edit", requirements={"id"="\d+"})
     */
    public function editAction(Request $request, int $id)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em      = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find($id);
            if ($product) {
                $form = $this->createForm(ProductType::class, $product);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($product);
                    $em->flush();
                    $this->addFlash('success', 'Produit modifié avec succès');
                    return $this->redirectToRoute('products_index');
                }
                return $this->render(':Product:edit.html.twig', ['form' => $form->createView()]);
            }
            return $this->createNotFoundException();
        }
        return $this->createNotFoundException();
    }
    
    /**
     * @param int $id
     * @return JsonResponse
     * @throws \LogicException
     * @Route("/products/delete/{id}", name="product_delete", requirements={"id"="\d+"})
     */
    public function deleteAction(int $id): JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em      = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find($id);
            if ($product) {
                $em->remove($product);
                $em->flush();
                return $this->json(['success' => true], Response::HTTP_OK);
            }
            return $this->json(['success' => false], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['success' => false], Response::HTTP_FORBIDDEN);
    }
}
