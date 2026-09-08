<?php

namespace App\Controller;

use App\Entity\Livro;
use App\Form\LivroType;
use App\Repository\LivroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;


final class LivroController extends AbstractController
{
    public function index(LivroRepository $livroRepository): Response
    {
        return $this->render('livro/index.html.twig', [
            'livros' => $livroRepository->findAll(),
        ]);
    }

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livro = new Livro();
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livro);
            $entityManager->flush();

            $this->addFlash('success', 'Livro cadastrado com sucesso!');
            return $this->redirectToRoute('livro_index');
        }

        return $this->render('livro/new.html.twig', [
            'livro' => $livro,
            'form' => $form,
        ]);
    }

    public function show(#[MapEntity(mapping: ['Codl' => 'Codl'])] Livro $livro): Response
    {
        return $this->render('livro/show.html.twig', [
            'livro' => $livro,
        ]);
    }

    public function edit(
        #[MapEntity(mapping: ['Codl' => 'Codl'])] Livro $livro,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Livro atualizado com sucesso!');
            return $this->redirectToRoute('livro_index');
        }

        return $this->render('livro/edit.html.twig', [
            'livro' => $livro,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, #[MapEntity(mapping: ['Codl' => 'Codl'])] Livro $livro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $livro->getCodl(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($livro);
            $entityManager->flush();
            $this->addFlash('success', 'Livro excluído com sucesso!');
        }

        return $this->redirectToRoute('livro_index');
    }
}
