<?php

namespace App\Controller;

use App\Entity\Leader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LeaderFormType;

class LeaderController extends AbstractController
{    
    
    #[Route('/leader/nuevo', name: 'nuevo_leader')]
    public function nuevo(ManagerRegistry $doctrine, Request $request){
        $leader = new Leader();

        $formulario = $this->createForm(LeaderFormType::class, $leader);

        $formulario->handleRequest($request);

            if($formulario->isSubmitted() && $formulario->isValid()){
                $leader = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($leader);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_leader', ["codigo" => $leader->getId()]);
            }

            return $this->render('nuevoleader.html.twig', array('formulario' => $formulario->createView()));

    }

    #[Route('/leader/editar/{codigo}', name: 'editar_leader')]
    public function editar(ManagerRegistry $doctrine, Request $request, $codigo){
        $repositorio = $doctrine->getRepository(Leader::class);
        $leader = $repositorio->find($codigo);

        if ($leader){
            $formulario = $this->createForm(LeaderFormType::class, $leader);

            $formulario->handleRequest($request);

            if($formulario->isSubmitted() && $formulario->isValid()){
                $leader = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($leader);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_leader', ["codigo" => $leader->getId()]);
            }

            return $this->render('editar_leader.html.twig', array('formulario' => $formulario->createView()));
        }else{
            return $this->render('ficha_leader.html.twig', [
                'leader' => NULL
            ]);
        }
    }

    #[Route('/leader/delete/{id}', name: 'eliminar_leader')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Leader::class);
        $leader = $repositorio->find($id);
        if ($leader){
            try
            {
                $entityManager->remove($leader);
                $entityManager->flush();
                return $this->render('eliminarleader.html.twig');
            } catch (\Exception $e) {
                return new Response("Error eliminando objetos");
            }
        }else
            return $this->render('ficha_leader.html.twig', ['leader' => null]);
    }
    #[Route('/leader/{codigo}', name: 'ficha_leader')]
    public function ficha(ManagerRegistry $doctrine, $codigo): Response
    {
        $repositorio = $doctrine->getRepository(Leader::class);
        $leader = $repositorio->find($codigo);
        return $this->render('ficha_leader.html.twig', [
            'leader' => $leader
        ]);
        
    }
}
