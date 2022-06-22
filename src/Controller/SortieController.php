<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Villes;
use App\Entity\ModelView;
use App\Entity\Sorties;
use App\Form\SearchFormSorties;
use App\Form\SortiesType;
use App\Repository\SortiesRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\InscriptionsRepository;
use App\Repository\SitesRepository;
use App\Service\SearchDataSorties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/", name="app_sortie_index", methods={"GET"})
     */
    public function index(
            EntityManagerInterface $entityManager, 
            SortiesRepository $sortiesRepository, 
            SitesRepository $sitesRepository, 
            ParticipantsRepository $participantsRepository, 
            Request $request
        ): Response
    {
        // Gestion de l'affichage de la date actuelle
        $dateNow = new \DateTime('now');
        $strDateNow = $dateNow->format('d/m/Y');

        // Gestion de la listye des sites
        $listSites = $sitesRepository -> findAll();
        dump($listSites);

        // gestion du formulaire de filtres
        $data = new SearchDataSorties();
        $formSearch = $this->createForm(SearchFormSorties::class, $data);
        $formSearch->handleRequest($request);

        // Gestion du user connecté et recherche de son id
        $userIdentifier = $this->getUser()->getUserIdentifier();
        $userId = $participantsRepository -> IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);

        // recupération des data selon le filtre selectionné
        $sorties = $sortiesRepository->findSearch($data);

        // Gestion des nb d'inscrits de la liste
        $i = 0;
        foreach ($sorties as $sorty){
            $noSorty = $sorty->getNoSortie();
            $nbinscrit[$i] = $sortiesRepository -> countInscrip($noSorty);
            $testinscr[$i] = $sortiesRepository -> inscripTrueFalse($noSorty,$ID );
            $i= $i + 1;
           /* $model = new ModelView();
            $model->setSortie ($sorty);
            $model->setNb (count($nbinscrit));
           array_push($modelTab;$model).*/

        };

        return $this->render('sortie/index.html.twig', [
            'dateNow' => $strDateNow,
            'listSites' => $listSites,
            'currentUser' => $userIdentifier,
            'sorties' => $sorties,
            'formSearch' => $formSearch->createView(),
            'nbinscrits' => $nbinscrit,
            'testinscrits' => $testinscr,
           /* 'tab'=>$modelTab */
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
          // dd($sorty);
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
    public function edit(Request $request, Sorties $sorty, EntityManagerInterface $entityManager, $noSortie): Response
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
        if ($this->isCsrfTokenValid('delete' . $sorty->getNoSortie(), $request->request->get('_token'))) {
            $entityManager->remove($sorty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{noSortie}/annuler", name="app_sortie_annuler", methods={"GET","POST"})
     */
    public function annuler(Request $request, Sorties $sorty, EntityManagerInterface $entityManager): Response
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

    /**
     * @Route("/{noSortie}/desiste", name="app_sortie_deleteInscri", methods={"GET","POST"})
     */
    public function deleteInscri(Sorties $sorty, InscriptionsRepository $inscriptionsRepository,  ParticipantsRepository $participantsRepository): Response
    {
        $userIdentifier = $this->getUser()->getUserIdentifier();
        $userId = $participantsRepository -> IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);

        $noSorty = $sorty->getNoSortie();

        $inscriptionsRepository -> desister($noSorty, $ID);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{noSortie}/inscrir", name="app_sortie_addInscri", methods={"GET","POST"})
     */
    public function addInscri(Sorties $sorty, InscriptionsRepository $inscriptionsRepository): Response
    {

        $noSorty = $sorty;
        $ID = $this->getUser();

        $inscriptionsRepository -> Sinscrire($noSorty, $ID);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{noSortie}/cancel", name="app_sortie_cancel", methods={"GET", "POST"})
     */
    public function cancel(Request $request, Sorties $sorty, EntityManagerInterface $entityManager, $noSortie): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/testCancel.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{noSortie}/cancelTest", name="app_sortie_cancel", methods={"GET", "POST"})
     */
    public function cancelTest(Request $request, Sorties $sorty, EntityManagerInterface $em, Sorties $sortie): Response
    {
        $participants = $this->getUser();
        $form = $this->createForm(CancelSortieType::class, $sorty);
        $form->handleRequest($request);

        $sortie->setDescriptioninfos($form['descriptioninfos']->getData());
       $sortie->setEtatsNoEtat("Annulée");

        $em->flush();
        $this->addFlash('success', 'La sortie a été annulée !');

        $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();
            return $this->redirectToRoute('app_sortie_index');
        

        
    }
}
