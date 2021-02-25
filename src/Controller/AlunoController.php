<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Aluno;

class AlunoController extends AbstractController
{
    /**
     * @Route("/", name="aluno")
     */
    public function index(): Response
    {
        return $this->render('aluno/index.html.twig', [
            'controller_name' => 'AlunoController',
        ]);
    }

    /**
     * @Route("/cadastrar", name="cadastrar")
     */
    public function cadastrar(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $nome = $request->request->get('nome');
        $nascimento = $request->request->get('nascimento');

        $aluno = new Aluno();
        $aluno->setNome($nome);
        $aluno->setDataNascimento(\DateTime::createFromFormat('Y-m-d', $nascimento));

        $entityManager->persist($aluno);

        $entityManager->flush();

        return new Response('O aluno foi cadastrado com ID: '.$aluno->getId());

        // return $this->render('aluno/index.html.twig', [
        //     'controller_name' => 'AlunoController',
        // ]);
    }
}
