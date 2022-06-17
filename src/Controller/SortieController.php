<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortiesType;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/", name="app_sortie_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, SortiesRepository $repository, Security $security): Response
    {
        $sorties = $entityManager
            ->getRepository(Sorties::class)
            ->findAll();
        /*$userId = $this->getUser()->getId();
        foreach ($sorties as $sorty) {
            $noSorty = $sorty->getNoSortie();
            $nbinscrit = $repository -> countInscrip($noSorty);
            $testinscr = $repository -> inscripBySortie($noSorty,$userId );
        };*/
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
        /*    'nbinscrit' => $nbinscrit,
            'testinscr' => $testinscr,  */
        ]);
    }

    /**
     * @Route("/new", name="app_sortie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sorty = new Sorties();
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sorty);
            $entityManager->flush();

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/new.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noSortie}", name="app_sortie_show", methods={"GET"})
     */
    public function show(Sorties $sorty, SortiesRepository $repository): Response
    {
        $noSorty = $sorty->getNoSortie();
        $inscrits = $repository->inscripBySortie($noSorty);

        return $this->render('sortie/show.html.twig', [
            'sorty' => $sorty,
            'inscrits' => $inscrits,
        ]);
    }

    /**
     * @Route("/{noSortie}/edit", name="app_sortie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sorties $sorty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noSortie}", name="app_sortie_delete", methods={"POST"})
     */
    public function delete(Request $request, Sorties $sorty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sorty->getNoSortie(), $request->request->get('_token'))) {
            $entityManager->remove($sorty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{noSortie}/annuler", name="app_sortie_annuler", methods={"GET","POST"})
     */
    public function annuler(Request $request,Sorties $sorty,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/annulerSortie.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }
}
