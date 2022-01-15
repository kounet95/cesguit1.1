<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdmiController extends AbstractController
{
    /**
     * @Route("/admin", name="admi")
     */
    public function index(): Response
    {
        return $this->render('admi/index.html.twig', [
            'controller_name' => 'AdmiController',
        ]);
    }
}
