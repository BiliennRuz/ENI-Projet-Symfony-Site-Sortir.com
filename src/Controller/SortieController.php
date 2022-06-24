<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Villes;
use App\Entity\ModelView;
use App\Entity\Sorties;
use App\Form\SearchFormSorties;
use App\Form\SortiesType;
use App\Repository\EtatsRepository;
use App\Repository\SortiesRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\InscriptionsRepository;
use App\Repository\SitesRepository;
use App\Service\SearchDataSorties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Validator\Constraints\Length;
use App\Form\CancelSortieType;
use Symfony\Component\Form\ClickableInterface;

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
        EtatsRepository $etatsRepository,
        ParticipantsRepository $participantsRepository,
        Request $request
    ): Response {
        ////////////////////////////////////////////////
        // Gestion de l'affichage de la date actuelle //
        ////////////////////////////////////////////////
        $dateNow = (new \DateTime('now'))->format('d/m/Y');

        /////////////////////////////////////////////
        // Gestion auto de l'archivage des sorties //
        /////////////////////////////////////////////
        $dateArchivage =  (new \DateTime('now'))->modify('-1 month');
        // recherche l'état corespondant à l'archivage
        $etatTerminée = $etatsRepository->findOneBy(['libelle' => 'Activité terminée']);
        $etatArchivee = $etatsRepository->findOneBy(['libelle' => 'Activité historisée']);
        // Liste les sorties de plus d'1 mois
        $listSortiesToArchivee = $sortiesRepository->findByDateDebut($dateArchivage);
        // update status pour chaque sortie
        foreach ($listSortiesToArchivee as $sortiesArchivee) {
            $sortiesArchivee->setEtatsNoEtat($etatArchivee);
        };
        // sauvegarde dans la base
        $entityManager->flush();

        ////////////////////////////////////////////
        // Gestion auto de la cloture des sorties //
        ////////////////////////////////////////////
        $dateCloture = new \DateTime('now');
        // recherche l'état corespondant à l'état ouverte et cloture
        $etatOuverte = $etatsRepository->findOneBy(['libelle' => 'Inscription ouverte']);
        $etatCloture = $etatsRepository->findOneBy(['libelle' => 'Inscription clôturée']);
        // Liste les sorties passée
        $listSortiesToCloturee = $sortiesRepository->findByDateClotureAndStatus($dateCloture, $etatOuverte);
        // update status pour chaque sortie
        foreach ($listSortiesToCloturee as $sortiesCloturee) {
            $sortiesCloturee->setEtatsNoEtat($etatCloture);
        };
        //dump($listSortiesToCloturee);
        // sauvegarde dans la base
        $entityManager->flush();

        //////////////////////////////////////
        // gestion du formulaire de filtres //
        //////////////////////////////////////
        $data = new SearchDataSorties();
        $formSearch = $this->createForm(SearchFormSorties::class, $data);
        $formSearch->handleRequest($request);

        // Gestion du user connecté et recherche de son id
        $userIdentifier = $this->getUser()->getUserIdentifier();
        $participant = $participantsRepository -> findOneBy(['email' => $userIdentifier]);
        dump($participant);
        $userId = $participantsRepository -> IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);

        // recupération des data selon le filtre selectionné
        $sorties = $sortiesRepository->findSearch($data, $participant);
        dump($sorties);

        // Gestion des nb d'inscrits de la liste
        $i = 0;
        $nbinscrit[0] = 0;
        $testinscr[0] = 0;
        foreach ($sorties as $sorty){
            $noSorty = $sorty->getNoSortie();
            $nbinscrit[$i] = $sortiesRepository->countInscrip($noSorty);
            $testinscr[$i] = $sortiesRepository->inscripTrueFalse($noSorty, $ID);
            $i = $i + 1;
            /* $model = new ModelView();
            $model->setSortie ($sorty);
            $model->setNb (count($nbinscrit));
           array_push($modelTab;$model).*/
        };
        //dd($nbinscrit);

        return $this->render('sortie/index.html.twig', [
            'dateNow' => $dateNow,
            'currentUser' => $userIdentifier,
            'Participant' => $participant,
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
    public function new(Request $request, EtatsRepository $etatsRepository,  ParticipantsRepository $participantsRepository, EntityManagerInterface $entityManager): Response
    {
        $sorty = new Sorties();
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        $userIdentifier = $this->getUser()->getUserIdentifier();
        $participant = $participantsRepository -> findOneBy(['email' => $userIdentifier]);
        dump($participant);

        if ($form->isSubmitted() && $form->isValid()) {
          // dd($sorty);

        if( isset($_POST['enregistrer']) ){
            $etat = $etatsRepository->findOneBy(['libelle' => 'Création en cours']);
            $sorty->setEtatsNoEtat($etat);
        }elseif( isset($_POST['publier'])){
            $etat = $etatsRepository->findOneBy(['libelle' => 'Inscription ouverte']);
            $sorty->setEtatsNoEtat($etat);
        }
            $sorty->setOrganisateur($participant);
            $entityManager->persist($sorty);
            $entityManager->flush();

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/new.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
            'organi' => $participant,
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
    public function edit(Request $request, Sorties $sorty, EntityManagerInterface $entityManager, EtatsRepository $etatsRepository, ParticipantsRepository $participantsRepository, $noSortie): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        $userIdentifier = $this->getUser()->getUserIdentifier();
        $participant = $participantsRepository -> findOneBy(['email' => $userIdentifier]);
        dump($participant);

        if ($form->isSubmitted() && $form->isValid()) {

            if( isset($_POST['enregistrer']) ){
                $etat = $etatsRepository->findOneBy(['libelle' => 'Création en cours']);
                $sorty->setEtatsNoEtat($etat);
            }elseif( isset($_POST['publier'])){
                $etat = $etatsRepository->findOneBy(['libelle' => 'Inscription ouverte']);
                $sorty->setEtatsNoEtat($etat);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
            'organi' => $participant,
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
        $userId = $participantsRepository->IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);

        $noSorty = $sorty->getNoSortie();

        $inscriptionsRepository->desister($noSorty, $ID);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{noSortie}/inscrir", name="app_sortie_addInscri", methods={"GET","POST"})
     */
    public function addInscri(Sorties $sorty, InscriptionsRepository $inscriptionsRepository): Response
    {

        $noSorty = $sorty;
        $ID = $this->getUser();

        $inscriptionsRepository->Sinscrire($noSorty, $ID);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    //     /**
    //  * @Route("/product/status", name="app_sortie_status", methods={"GET", "POST"})
    //  */
    // public function updateStatus(ManagerRegistry $doctrine):Response
    // {
    //     $entityManager = $doctrine->getManager();
    //     $listSorties = $entityManager->getRepository(Sorties::class)->findBy($id);
    //     $dateArchivage = new \DateTime('now');
    //     $dateArchivage->modify('+1 month');

    //     if (!$listSorties) {
    //         throw $this->createNotFoundException(
    //             'No sorties found'
    //         );
    //     }
    //     if ($listSorties->getDatedebut() >= $dateArchivage) {
    //         dump($listSorties);
    //     }
    //     $product->setName('New product name!');
    //     $entityManager->flush();

    //     return $this->redirectToRoute('product_show', [
    //         'id' => $product->getId()
    //     ]);
    // }


    /**
     * @Route("/{noSortie}/cancel", name="app_sortie_cancel", methods={"GET","POST"})
     */
    public function annulerSortie(
        Request $request,
        EntityManagerInterface $em,
        Sorties $sorty,
        EtatsRepository $etatsRepository,
        SortiesRepository $sortiesRepository
    ): Response {

        $form = $this->createForm(CancelSortieType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);

            $etatAnnulee = $etatsRepository->findOneBy(['libelle' => 'Annulée']);

            
            $sorty->setEtatsNoEtat($etatAnnulee);
            $sorty->setDescriptioninfos('');
            $sorty->getDescriptioninfos('');
            $em->flush();
           

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
            $this->addFlash('success', 'La sortie a été annulée !');
        }
        return $this->renderForm('sortie/annulerSortie.html.twig', [
            'sorty' => $sorty,
            'form' => $form,

        ]);
    }
}
