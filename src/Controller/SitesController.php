<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Form\SearchFormNom;
use App\Form\SitesType;
use App\Repository\SitesRepository;
use App\Service\SearchDataNom;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sites")
 */
class SitesController extends AbstractController
{
    /**
     * @Route("/", name="app_sites", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, SitesRepository $repository, Request $request): Response
    {
        $data = new SearchDataNom();
        $formSearch = $this->createForm(SearchFormNom::class, $data);
        $formSearch->handleRequest($request);
        
        $sites = $repository->findSearch($data);

        return $this->render('sites/index.html.twig', [
            'sites' => $sites,
            'formSearch' => $formSearch->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_sites_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SitesRepository $repository): Response
    {
        $site = new Sites();
        $form = $this->createForm(SitesType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($site);
            //$entityManager->persist($site);
            //$entityManager->flush();
            dd($repository);
            return $this->redirectToRoute('app_sites', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sites/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noSite}", name="app_sites_show", methods={"GET"})
     */
    public function show(Sites $site): Response
    {
        return $this->render('sites/show.html.twig', [
            'site' => $site,
        ]);
    }

    /**
     * @Route("/{noSite}/edit", name="app_sites_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sites $site, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SitesType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sites', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sites/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noSite}", name="app_sites_delete", methods={"POST"})
     */
    public function delete(Request $request, Sites $site, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$site->getNoSite(), $request->request->get('_token'))) {
            $entityManager->remove($site);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sites', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * TODO Test filtre de recherche
     * @Route("/search/{noSite}", name="app_sites_search", methods={"GET"})
     */
    public function searchName(EntityManagerInterface $entityManager): Response
    {
        $sites = $entityManager
            ->getRepository(Sites::class)
            ->findBy();

        return $this->render('sites/index.html.twig', [
            'sites' => $sites,
        ]);
    }

}
