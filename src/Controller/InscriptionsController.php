<?php

namespace App\Controller;

use App\Controller\SortieController;
use App\Entity\Sorties;
use App\Entity\Inscriptions;
use App\Form\InscriptionsType;
use App\Repository\InscriptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/inscriptions")
 */
class InscriptionsController extends AbstractController
{
    /**
     * @Route("/", name="app_inscriptions_index", methods={"GET"})
     */
    public function index(InscriptionsRepository $inscriptionsRepository): Response
    {
        return $this->render('inscriptions/index.html.twig', [
            'inscriptions' => $inscriptionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_inscriptions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InscriptionsRepository $inscriptionsRepository): Response
    {
        $inscription = new Inscriptions();
        $form = $this->createForm(InscriptionsType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscriptionsRepository->add($inscription, true);

            return $this->redirectToRoute('app_inscriptions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscriptions/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{sortiesNoSortie}", name="app_inscriptions_show", methods={"GET"})
     */
    public function show(Inscriptions $inscription): Response
    {
        return $this->render('inscriptions/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    /**
     * @Route("/{sortiesNoSortie}/edit", name="app_inscriptions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Inscriptions $inscription, InscriptionsRepository $inscriptionsRepository): Response
    {
        $form = $this->createForm(InscriptionsType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscriptionsRepository->add($inscription, true);

            return $this->redirectToRoute('app_inscriptions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscriptions/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{noSortie}", name="app_inscriptions_delete", methods={"POST"})
     */
    public function delete(Sorties $sorty, InscriptionsRepository $inscriptionsRepository,  ParticipantsRepository $participantsRepository): Response
    {
        /*$userIdentifier = $this->getUser()->getUserIdentifier();
        $userId = $participantsRepository -> IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);*/

        /*$noSorty = $sorty->getNoSortie();*/

        $ID = $this->getUser();

        $inscriptionsRepository -> desister($sorty, $ID);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
}
