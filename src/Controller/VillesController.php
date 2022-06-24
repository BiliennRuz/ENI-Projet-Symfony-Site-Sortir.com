<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\SearchFormNom;
use App\Form\VillesType;
use App\Repository\VillesRepository;
use App\Service\SearchDataNom;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/villes")
 */
class VillesController extends AbstractController
{
    /**
     * @Route("/", name="app_villes", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, VillesRepository $repository, Request $request): Response
    {
        $data = new SearchDataNom();
        $formSearch = $this->createForm(SearchFormNom::class, $data);
        $formSearch->handleRequest($request);

        $villes = $repository->findSearch($data);
        // $villes = $entityManager
        //     ->getRepository(Villes::class)
        //     ->findAll();

        return $this->render('villes/index.html.twig', [
            'villes' => $villes,
            'formSearch' => $formSearch->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_villes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ville = new Villes();
        $form = $this->createForm(VillesType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ville);
            $entityManager->flush();

            return $this->redirectToRoute('app_villes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('villes/new.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noVille}", name="app_villes_show", methods={"GET"})
     */
    public function show(Villes $ville): Response
    {
        return $this->render('villes/show.html.twig', [
            'ville' => $ville,
        ]);
    }

    /**
     * @Route("/{noVille}/edit", name="app_villes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Villes $ville, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VillesType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_villes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('villes/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noVille}", name="app_villes_delete", methods={"POST"})
     */
    public function delete(Request $request, Villes $ville, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getNoVille(), $request->request->get('_token'))) {
            $entityManager->remove($ville);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_villes', [], Response::HTTP_SEE_OTHER);
    }
}
