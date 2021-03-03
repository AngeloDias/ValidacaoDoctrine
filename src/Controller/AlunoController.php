<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AlunoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Aluno;

class AlunoController extends AbstractController
{

    /**
     * @Route("/aluno/remover/{id}", name="aluno_remover")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $aluno = $entityManager->getRepository(Aluno::class)->find($id);

        $id = $aluno->getId();

        $entityManager->remove($aluno);
        $entityManager->flush();

        // return new Response('Aluno de ID "'.$id.'" removido.');

        return $this->redirectToRoute('listar_alunos');
    }

     /**
     * @Route("/aluno/editar/{id}", name="aluno_editar")
     */
    public function update(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $aluno = $entityManager->getRepository(Aluno::class)->find($id);

        if ($request->isMethod('POST')) {
            $aluno->setNome($request->request->get('nome'));
            $aluno->setCurso($request->request->get('curso'));

            $entityManager->persist($aluno);

            $entityManager->flush();

            return new Response('O aluno foi atualizado com nome: '.$aluno->getNome());
        }

        $form = $this->createForm(AlunoType::class, $aluno);
        $form->handleRequest($request);

        return $this->render('aluno/editar.html.twig', [
            'aluno' => $aluno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/aluno/{id}", name="aluno_show")
     */
    public function show(int $id): Response
    {
        $aluno = $this->getDoctrine()
            ->getRepository(Aluno::class)
            ->find($id);

        if (!$aluno) {
            throw $this->createNotFoundException(
                'Nenhum aluno encontrado com o ID: '.$id
            );
        }

        return $this->redirectToRoute('listar_alunos');

        // return new Response('O nome do aluno selecionado: '.$aluno->getNome());
    }

    /**
     * @Route("/listar", name="listar_alunos")
     */
    public function listar(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        return $this->render('aluno/listar.html.twig', [
            'alunos' => $entityManager->getRepository(Aluno::class)->findAll(),
            'errors' => ''
        ]);
    }

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

        return $this->redirectToRoute('listar_alunos');

        // return new Response('O aluno foi cadastrado com ID: '.$aluno->getId());
    }
}
