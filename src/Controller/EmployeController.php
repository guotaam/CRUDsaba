<?php

namespace App\Controller;
use App\Form\EmployeType;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/', name: 'app_employe')]
    public function index(EmployeRepository $repo): Response
    {
        $employes=$repo->findAll();
        return $this->render('employe/liste.html.twig', [
            'employes' => $employes,
        ]);
    }

 

    #[Route('/employe/ajouter', name: 'ajouter_employe')]
    #[Route('/employe/modifier/{id}', name: 'modifier_employe')]
    public function form(Request $globals,EntityManagerInterface $Manager,Employe $employe = null)
    {
        if($employe == null)
        {
                 
          $employe=new Employe;
       
        }
        $form= $this->createForm(EmployeType::class,$employe);  
        $form->handleRequest($globals);

    if($form->isSubmitted()&& $form->isValid())
    {
       $Manager->persist($employe);
       $Manager->flush();
       
       return $this->redirectToRoute('app_employe',[
        'id'=>$employe->getId()
        ]);
       
    }
    return $this->renderForm("employe/form.html.twig",[
        'formEmploye'=> $form,
        'editMode'=>$employe->getId()!== null
    ]);  
    }

    
    #[Route('/employe/supprimer/{id}', name: 'supprimer_employe')]

    public function delete($id,EntityManagerInterface $manager,EmployeRepository $repo)
    {

      $employe=$repo->find($id);
      $manager->remove($employe);//preparer
      $manager->flush();//executer la supp
       return $this->redirectToRoute('app_employe');


    }




}
