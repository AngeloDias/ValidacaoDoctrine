<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Student;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentController extends AbstractController
{
    /**
     * @Route("/student/{id}", name="studentSS")
     */
    public function showAndSave(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->getRepository(Student::class)->find($id);

        if($student == null) {
            $student = new Student();
        }

        $form = $this->createFormBuilder($student)
            ->add('title', TextType::class)
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class,  ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('list_students');
        }

        return $this->render('student/form_student.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/student_index", name="student")]
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/list", name="list_students")
     */
    public function listar(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $students = $entityManager->getRepository(Student::class)->findAll();

        return $this->render('student/students.html.twig', [
            'students' => $students
        ]);
    }

}
