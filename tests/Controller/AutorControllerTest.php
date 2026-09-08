<?php

namespace App\Tests\Controller;

use App\Entity\Autor;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AutorControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<Autor> */
    private EntityRepository $autorRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->autorRepository = $this->manager->getRepository(Autor::class);

        // Limpa registros anteriores para garantir isolamento
        foreach ($this->autorRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/autores');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('table');
    }

    public function testNew(): void
    {
        $crawler = $this->client->request('GET', '/autores/novo');
        self::assertResponseIsSuccessful();

        // Submete apenas o campo 'Nome' conforme mapeado no AutorType
        $form = $crawler->selectButton('Salvar')->form([
            'autor[Nome]' => 'Machado de Assis',
        ]);

        $this->client->submit($form);

        self::assertResponseRedirects('/autores');
        $this->client->followRedirect();

        self::assertSame(1, $this->autorRepository->count([]));
        self::assertSelectorTextContains('table', 'Machado de Assis');
    }

    public function testEdit(): void
    {
        $fixture = new Autor();
        $fixture->setNome('Clarice Lispector');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $crawler = $this->client->request('GET', sprintf('/autores/%d/editar', $fixture->getCodAu()));
        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Salvar')->form([
            'autor[Nome]' => 'Clarice Lispector Atualizada',
        ]);

        $this->client->submit($form);

        self::assertResponseRedirects('/autores');

        $autorAtualizado = $this->autorRepository->find($fixture->getCodAu());
        self::assertSame('Clarice Lispector Atualizada', $autorAtualizado->getNome());
    }

    public function testRemove(): void
    {
        $fixture = new Autor();
        $fixture->setNome('Monteiro Lobato');

        $this->manager->persist($fixture);
        $this->manager->flush();

        // Simula o formulário de exclusão contendo o token CSRF
        $this->client->request('POST', sprintf('/autores/%d/excluir', $fixture->getCodAu()), [
            '_token' => $this->client->getContainer()->get('security.csrf.token_manager')->getToken('delete' . $fixture->getCodAu())->getValue(),
        ]);

        self::assertResponseRedirects('/autores');
        self::assertSame(0, $this->autorRepository->count([]));
    }
}