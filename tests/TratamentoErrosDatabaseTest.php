<?php

namespace App\Tests;

use App\Entity\Autor;
use App\Entity\Livro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class TratamentoErrosDatabaseTest extends WebTestCase

{

    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }
        parent::tearDown();
    }

    public function testInterceptaFkConstraintAoExcluirAutorComLivro(): void
{
    // 1. Arrange: Cria o Autor e o Livro vinculado
    $autor = new Autor();
    $autor->setNome('Autor Teste FK');
    $this->entityManager->persist($autor);

    $livro = new Livro();
    $livro->setTitulo('Livro Teste FK ' . uniqid());
    $livro->setEdicao(1);
    $livro->setEditora('Editora Teste');

    if (method_exists($livro, 'setValor')) {
        $livro->setValor('50.00');
    }
    if (method_exists($livro, 'setAnoPublicacao')) {
        $livro->setAnoPublicacao('2024');
    }

    $livro->addAutor($autor);

    $this->entityManager->persist($livro);
    $this->entityManager->flush();

    $codAu = $autor->getCodAu();

    // 2. Act: Faz um GET inicial na rota de edição ou exibição onde o botão de delete fica
    // Isso inicializa a sessão HTTP no client e carrega o token CSRF oficial
    $crawler = $this->client->request('GET', sprintf('/autor/%d/edit', $codAu));

    // Seleciona o formulário de exclusão existente no Twig e faz o submit
    // (Geralmente o botão se chama 'Delete', 'Excluir' ou está em um form com action para /autor/{CodAu})
    if ($crawler->selectButton('Excluir')->count() > 0) {
        $form = $crawler->selectButton('Excluir')->form();
        $this->client->submit($form);
    } elseif ($crawler->selectButton('Delete')->count() > 0) {
        $form = $crawler->selectButton('Delete')->form();
        $this->client->submit($form);
    } else {
        // Fallback: se preferir extrair diretamente o input hidden do form
        $token = $crawler->filter('form input[name="_token"]')->attr('value');
        $this->client->request('POST', sprintf('/autor/%d', $codAu), [
            '_token' => $token,
        ]);
    }

    // 3. Assert: Valida redirecionamento (302) sem erro 500
    $this->assertResponseStatusCodeSame(302, 'Deveria redirecionar interceptado pelo listener.');

    $this->client->followRedirect();

    // 4. Valida se a mensagem flash de erro de dependência apareceu
    $this->assertAnySelectorTextContains(
        '.alert-danger',
        'Não foi possível concluir a ação: este registro possui vínculos ativos no sistema.'
    );
}
}
