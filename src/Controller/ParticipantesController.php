<?php

namespace App\Controller;

use App\Entity\Leader;
use App\Entity\Participante;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ParticipanteType;

class ParticipantesController extends AbstractController
{
       
    #[Route('/participante/nuevo', name: 'nuevo_participante')]
    public function nuevo(ManagerRegistry $doctrine, Request $request){
        $participante = new Participante();

        $formulario = $this->createForm(ParticipanteType::class, $participante);

        $formulario->handleRequest($request);

            if($formulario->isSubmitted() && $formulario->isValid()){
                $participante = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($participante);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_participante', ["codigo" => $participante->getId()]);
            }

            return $this->render('nuevo.html.twig', array('formulario' => $formulario->createView()));

    }

    #[Route('/participante/editar/{codigo}', name: 'editar_participante')]
    public function editar(ManagerRegistry $doctrine, Request $request, $codigo){
        $repositorio = $doctrine->getRepository(Participante::class);
        $participante = $repositorio->find($codigo);

        if ($participante){
            $formulario = $this->createForm(ParticipanteType::class, $participante);

            $formulario->handleRequest($request);

            if($formulario->isSubmitted() && $formulario->isValid()){
                $participante = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($participante);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_participante', ["codigo" => $participante->getId()]);
            }

            return $this->render('editar.html.twig', array('formulario' => $formulario->createView()));
        }else{
            return $this->render('ficha_participante.html.twig', [
                'participante' => NULL
            ]);
        }
    }
    
    /*#[Route('/participante/insertar', name: 'insertar_participante')]
    public function insertar(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        foreach($this->participantes as $p){
            $participante = new Participante();
            $participante->setNombre($p["nombre"]);
            $participante->setJid($p["jid"]);
            $participante->setScore($p["score"]);
            $entityManager->persist($participante);
        }
        
        try
        {
            $entityManager->flush();
            return new Response("Participantes insertados");
        } catch (\Exception $e) {
            return new Response("Error insertando objetos");
        }
    }*/

    /*#[Route('/participante/update/{id}/{nombre}', name: 'modificar_participante')]
    public function update(ManagerRegistry $doctrine, $id, $nombre): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Participante::class);
        $participante = $repositorio->find($id);
        if ($participante){
            $participante->setNombre($nombre);
            try
            {
                $entityManager->flush();
                return $this->render('ficha_participante.html.twig', ['participante' => $participante]);
            } catch (\Exception $e) {
                return new Response("Error modificando objetos");
            }
        }else
            return $this->render('ficha_participante.html.twig', ['participante' => null]);
    }*/

    #[Route('/participante/delete/{id}', name: 'eliminar_participante')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Participante::class);
        $participante = $repositorio->find($id);
        if ($participante){
            try
            {
                $entityManager->remove($participante);
                $entityManager->flush();
                return $this->render('eliminar.html.twig');
            } catch (\Exception $e) {
                return new Response("Error eliminando objetos");
            }
        }else
            return $this->render('ficha_participante.html.twig', ['participante' => null]);
    }

    /*#[Route('/participante/insertarConLeader', name: 'insertar_con_leader_participante')]
    public function insertarConLeader(ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $leader = new Leader();
                
        $leader->setNombre("Nami");
        $leader->setCodigo("OP03-001");

        $participante = new Participante();

        $participante->setNombre("Nombre1");
        $participante->setJid("00000001");
        $participante->setScore("0-3-0");
        $participante->setLeader($leader);
      
        $entityManager->persist($leader);
        $entityManager->persist($participante);

        $entityManager->flush();
        return $this->render('ficha_participante.html.twig', [
            'participante' => $participante
        ]);
    }*/

    /*#[Route('/participante/insertarSinLeader', name: 'insertar_sin_leader_participante')]
    public function insertarSinLeader(ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Leader::class);

        $leader = $repositorio->findOneBy(["nombre" => "Nami"]);

        $participante = new Participante();

        $participante->setNombre("Nombre2");
        $participante->setJid("00000002");
        $participante->setScore("1-2-0");
        $participante->setLeader($leader);

        $entityManager->persist($participante);

        $entityManager->flush();
        return $this->render('ficha_participante.html.twig', ['participante' => $participante]);
    }*/

    #[Route('/participante/{codigo}', name: 'ficha_participante')]
    public function ficha(ManagerRegistry $doctrine, $codigo): Response
    {
        $repositorio = $doctrine->getRepository(Participante::class);
        $participante = $repositorio->find($codigo);
        return $this->render('ficha_participante.html.twig', [
            'participante' => $participante
        ]);
        
    }

    #[Route('/participante/buscar/{jid}', name: 'ficha_participante_jid',
    requirements: ['jid' => '\d+'])]
    public function fichajid(ManagerRegistry $doctrine, $jid): Response
    {
        $repositorio = $doctrine->getRepository(Participante::class);
        $participante = $repositorio->findOneBy(["jid" => $jid]);
        return $this->render('ficha_participante.html.twig', [
            'participante' => $participante
        ]);
        
    }

    #[Route('/participante/buscar/{nombre}', name: 'buscar_participante')]
    public function buscar(ManagerRegistry $doctrine, $nombre): Response{
        
        $repositorio = $doctrine->getRepository(Participante::class);
        $participantes = $repositorio->findByName($nombre);

        return $this->render('lista_participantes.html.twig', [
            'participantes' => $participantes
        ]);
    }
}
