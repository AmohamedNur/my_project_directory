<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{

    #[Route('/department/new', name: 'app_department')]
    public function newAction(Request $request, EntityManagerInterface $em):Response
    {
        $department=new Department();
        $form=$this->createForm(DepartmentType::class,$department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $department=$form->getData();
            $em->persist($department);
            $em->flush();

            $this->addFlash('success', 'Department Created');
            return $this->redirectToRoute('app_department');
        }
        return $this->renderForm('department/new.html.twig', ['departmentForm' => $form,]);
    }
}
