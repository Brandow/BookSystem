<?php

namespace App\Controller;

use App\Entity\Assunto;
use App\Form\AssuntoType;
use App\Repository\AssuntoRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

final class AssuntoController extends AbstractController
{
    public function index(AssuntoRepository $assuntoRepository): Response
    {
        return $this->render('assunto/index.html.twig', [
            'assuntos' => $assuntoRepository->findAll(),
        ]);
    }

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assunto = new Assunto();
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assunto);
            $entityManager->flush();

            $this->addFlash('success', 'Assunto cadastrado com sucesso!');

            return $this->redirectToRoute('assunto_index');
        }

        return $this->render('assunto/new.html.twig', [
            'assunto' => $assunto,
            'form' => $form,
        ]);
    }

    public function show(#[MapEntity(mapping: ['CodAs' => 'CodAs'])] Assunto $assunto): Response
    {
        return $this->render('assunto/show.html.twig', [
            'assunto' => $assunto,
        ]);
    }

    public function edit(#[MapEntity(mapping: ['CodAs' => 'CodAs'])] Assunto $assunto, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Assunto atualizado com sucesso!');

            return $this->redirectToRoute('assunto_index');
        }

        return $this->render('assunto/edit.html.twig', [
            'assunto' => $assunto,
            'form' => $form,
        ]);
    }

    public function delete(#[MapEntity(mapping: ['CodAs' => 'CodAs'])] Assunto $assunto, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $assunto->getCodAs(), $request->getPayload()->getString('_token'))) {
            // Sem essa verificação o doctrine simplesmente ignora a regra do sql e apaga mesmo assim kkkkkk
            if (!$assunto->getLivros()->isEmpty()) {
                $this->addFlash('error', 'Este assunto está vinculado a um ou mais livros e não pode ser excluído.');
            } else {
                $entityManager->remove($assunto);
                $entityManager->flush();
                $this->addFlash('success', 'Assunto excluído com sucesso!');
            }
        }

        return $this->redirectToRoute('assunto_index');
    }
}