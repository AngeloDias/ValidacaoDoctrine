<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlunoController extends AbstractController
{
    /**
     * @Route("/aluno", name="aluno")
     */
    public function index(): Response
    {
        return $this->render('aluno/index.html.twig', [
            'controller_name' => 'AlunoController',
        ]);
    }
}
