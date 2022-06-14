<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/",name="app_accueil")
     */
    public function index():Response{
        
        return $this->render("layouts/base.html.twig");
    }

    /**
     * @Route("/",name="app_monprofil")
     */
    public function index2():Response{
        
        return $this->render("layouts/base.html.twig");
    }

 /**
     * @Route("/",name="app_sedeconnecter")
     */
    public function index3():Response{
        
        return $this->render("layouts/base.html.twig");
    }

    /**
     * @Route("/",name="app_villes")
     */
    public function index4():Response{
        
        return $this->render("layouts/base.html.twig");
    }

    /**
     * @Route("/",name="app_sites")
     */
    public function index5():Response{
        
        return $this->render("layouts/base.html.twig");
    }
}