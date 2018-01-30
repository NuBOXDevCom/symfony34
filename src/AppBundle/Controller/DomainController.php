<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domain;
use AppBundle\Form\DomainType;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DomainController
 * @package AppBundle\Controller
 */
class DomainController extends Controller
{
    /**
     * @param int $page
     * @return Response
     * @throws NotFoundHttpException
     * @throws LogicException
     * @Route("/domains/{page}", name="domains_index", requirements={"page"="\d+"}, defaults={"page"="1"})
     */
    public function indexAction(int $page = 1): Response
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page $page n'existe pas.");
        }
        $em     = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        if ($this->isGranted('ROLE_ADMIN')) {
            $listDomains = $em->getRepository(Domain::class)
                              ->getAllDomainsPaginator($page, $this->getParameter('results_per_page'));
        } else {
            $listDomains = $em->getRepository(Domain::class)
                              ->getDomainsByUserIdPaginator($userId, $page, $this->getParameter('results_per_page'));
        }
        $pagination = [
            'page'         => $page,
            'route'        => 'domains_index',
            'pages_count'  => ceil($listDomains->count() / $this->getParameter('results_per_page')),
            'route_params' => []
        ];
        return $this->render(':Domain:list.html.twig', [
            'domains'    => $listDomains,
            'pagination' => $pagination
        ]);
    }
    
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws LogicException
     * @Route("/domains/add", name="domains_add")
     */
    public function addAction(Request $request)
    {
        $domain = new Domain();
        $form   = $this->createForm(DomainType::class, $domain, ['role' => $this->getUser()->getRoles()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $domain->setEnabled(true);
                $domain->setUser($this->getUser());
            }
            $domain->setName(preg_replace('#^[^:/.]*[:/]+#i', '', trim($form->getData()->getName(), '/')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($domain);
            $em->flush();
            $this->addFlash('success', 'Domaine ajouté avec succès');
            return $this->redirectToRoute('domains_index');
        }
        return $this->render(':Domain:add.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @param int $id
     * @return JsonResponse
     * @throws LogicException
     * @Route("/domains/delete/{id}", name="domains_delete", requirements={"id"="\d+"})
     */
    public function deleteAction(int $id): ?JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $domain = $em->getRepository(Domain::class)->find($id);
        if ($domain) {
            if ($this->isGranted('ROLE_ADMIN') || $this->getUser()->getId() === $domain->getUser()->getId()) {
                $em->remove($domain);
                $em->flush();
                return $this->json(['success' => true], Response::HTTP_OK);
            }
            return $this->json(['success' => false], Response::HTTP_FORBIDDEN);
        }
        return $this->json(['success' => false], Response::HTTP_BAD_REQUEST);
    }
    
    /**
     * @param Request $request
     * @param int     $id
     * @return RedirectResponse|Response|NotFoundHttpException
     * @throws LogicException
     * @Route("/domains/edit/{id}", requirements={"id"="\d+"}, name="domains_edit")
     */
    public function editAction(Request $request, int $id)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em     = $this->getDoctrine()->getManager();
            $domain = $em->getRepository(Domain::class)->find($id);
            if ($domain) {
                $form = $this->createForm(DomainType::class, $domain, ['role' => $this->getUser()->getRoles()]);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $domain->setName(preg_replace('#^[^:/.]*[:/]+#i', '', trim($form->getData()->getName(), '/')));
                    $em->persist($domain);
                    $em->flush();
                    $this->addFlash('success', 'Domaine modifié avec succès');
                    return $this->redirectToRoute('domains_index');
                }
                return $this->render(':Domain:edit.html.twig', ['form' => $form->createView()]);
            }
            $this->addFlash('error', 'Domaine introuvable');
            return $this->redirectToRoute('domains_index');
        }
        return $this->createNotFoundException();
    }
    
    /**
     * @param int $id
     * @param int $value
     * @return JsonResponse
     * @throws LogicException
     * @Route("/domains/changestatus/{id}/{value}", requirements={"id"="\d+", "value"="\d+"},
     *     name="domains_changestatus")
     */
    public function changeStatusAction(int $id, int $value): ?JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em     = $this->getDoctrine()->getManager();
            $domain = $em->getRepository(Domain::class)->find($id);
            if ($domain) {
                $status = $value;
                $domain->setEnabled($status);
                $em->persist($domain);
                $em->flush();
                return $this->json(['success' => true], Response::HTTP_OK);
            }
            return $this->json(['success' => false], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['success' => false], Response::HTTP_FORBIDDEN);
    }
}
