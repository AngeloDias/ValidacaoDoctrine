<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            'errors' => ''
        ]);
    }

    /**
     * @Route("/cadastrar", name="cadastrar")
     */
    public function cadastrar(ValidatorInterface $validator, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $nome = $request->request->get('nome');
        $curso = $request->request->get('curso');

        $aluno = new Aluno();
        $aluno->setNome($nome);
        $aluno->setCurso($curso);

        $erros = $validator->validate($aluno);

        if(count($erros) > 0) {
            return $this->render('aluno/index.html.twig', [
                'errors' => $erros
            ]);
        }

        $entityManager->persist($aluno);

        $entityManager->flush();

        return new Response('O aluno foi cadastrado com ID: '.$aluno->getId());
    }
}
