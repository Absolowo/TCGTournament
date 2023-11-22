<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantesController extends AbstractController
{
    private $participantes = [
        1 => ["nombre" => "Juan Pérez", "id" => "524142432", "score" => "2-0-0", "leader" => "Trafalgar Law"],
        2 => ["nombre" => "Ana López", "id" => "58958448", "score" => "1-0-1", "leader" => "Edward Newgate"],
        3 => ["nombre" => "Mario Montero", "id" => "5326824", "score" => "1-0-1", "leader" => "Roronoa Zoro"],
        4 => ["nombre" => "Laura Martínez", "id" => "42898966", "score" => "0-0-2", "leader" => "Roronoa Zoro"]
    ]; 
    #[Route('/participante/{codigo}', name: 'ficha_participante')]
    public function ficha($codigo): Response
    {
        $resultado = ($this->participantes[$codigo] ?? null);
        return $this->render('ficha_participante.html.twig', [
            'participante' => $resultado
        ]);
        
    }
    #[Route('/participante/buscar/{texto}', name: 'buscar_participante')]
    public function buscar($texto): Response{
        $resultados = array_filter($this->participantes,
            function ($participante) use ($texto){
                return strpos($participante["nombre"], $texto) !== FALSE;
            }
        );
        return $this->render('lista_participantes.html.twig', [
            'participantes' => $resultados
        ]);
    }
}
