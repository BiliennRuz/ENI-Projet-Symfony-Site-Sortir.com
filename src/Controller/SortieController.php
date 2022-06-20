<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\ModelView;
use App\Entity\Sorties;
use App\Form\SearchFormSorties;
use App\Form\SortiesType;
use App\Repository\SortiesRepository;
use App\Repository\ParticipantsRepository;
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
    public function index(EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository, ParticipantsRepository $participantsRepository, Request $request): Response
    {
        $data = new SearchDataSorties();
        $formSearch = $this->createForm(SearchFormSorties::class, $data);
        $formSearch->handleRequest($request);
/*
        $sorties = $entityManager
            ->getRepository(Sorties::class)
            ->findAll();
            ->findSearch($data);
*/
        $sorties = $sortiesRepository->findSearch($data);

        $userIdentifier = $this->getUser()->getUserIdentifier();
        $userId = $participantsRepository -> IdfromPseudoEmail($userIdentifier);
        $array1 = $userId[0];
        $ID = intval($array1["id"]);

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
          //upload d'image
          $urlPhoto = $form->get('urlphoto')->getData();

          // this condition is needed because the 'urlphoto' field is not required
          // so thefile must be processed only when a file is uploaded
          if ($urlPhoto) {
              $originalFilename = pathinfo($urlPhoto->getClientOriginalName(), PATHINFO_FILENAME);
              // this is needed to safely include the file name as part of the URL
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$urlPhoto->guessExtension();

              // Move the file to the directory where images are stored
              try {
                  $urlPhoto->move(
                      $this->getParameter('images_directory'),
                      $newFilename
                  );
              } catch (FileException $e) {
                  // ... handle exception if something happens during file upload
              }

              // updates the 'brochureFilename' property to store the PDF file name
              // instead of its contents
              $sorties->setUrlPhoto($newFilename);
          }

          // ... persist the $product variable or any other work

          return $this->redirectToRoute('app_sortie_index');
      }

      return $this->renderForm('sortie/new.html.twig', [
        'sorty' => $sorty,
        'form' => $form,
      ]);

          //
            $entityManager->persist($sorty);
            $entityManager->flush();

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        /*return $this->renderForm('sortie/new.html.twig', [
            'sorty' => $sorty,
            'form' => $form,*/
        
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
