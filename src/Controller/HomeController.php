<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LivroRepository;
use App\Repository\AutorRepository;
use App\Repository\AssuntoRepository;

final class HomeController extends AbstractController
{
    public function index(LivroRepository $livrosRepository, AutorRepository $autoresRepository, AssuntoRepository $assuntosRepository): Response
    {

        $totalLivros = $livrosRepository->count([]);
        $totalAutores = $autoresRepository->count([]);
        $totalAssuntos = $assuntosRepository->count([]);

        return $this->render('home/index.html.twig', [
            'livro_count' => $totalLivros,
            'autor_count' => $totalAutores,
            'assunto_count' => $totalAssuntos,
        ]);
    }
}
