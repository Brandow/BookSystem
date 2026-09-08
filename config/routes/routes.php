<?php

use App\Controller\AssuntoController;
use App\Controller\AutorController;
use App\Controller\HomeController;
use App\Controller\LivroController;
use App\Controller\RelatorioController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

    // Rotas Home    
    $routes->add('home', '/')
        ->controller([HomeController::class, 'index'])
        ->methods(['GET']);

    // Rotas Livro
    $routes->add('livro_index', '/livro')
        ->controller([LivroController::class, 'index'])
        ->methods(['GET']);

    $routes->add('livro_new', '/livro/new')
        ->controller([LivroController::class, 'new'])
        ->methods(['GET', 'POST']);

    $routes->add('livro_show', '/livro/{Codl}')
        ->controller([LivroController::class, 'show'])
        ->methods(['GET']);

    $routes->add('livro_edit', '/livro/{Codl}/edit')
        ->controller([LivroController::class, 'edit'])
        ->methods(['GET', 'POST']);

    $routes->add('livro_delete', '/livro/{Codl}')
        ->controller([LivroController::class, 'delete'])
        ->methods(['POST']);


    // Rotas Assunto
    $routes->add('assunto_index', '/assunto')
        ->controller([AssuntoController::class, 'index'])
        ->methods(['GET']);

    $routes->add('assunto_new', '/assunto/new')
        ->controller([AssuntoController::class, 'new'])
        ->methods(['GET', 'POST']);

    $routes->add('assunto_show', '/assunto/{CodAs}')
        ->controller([AssuntoController::class, 'show'])
        ->defaults([
            '_entity' => [
                'mapping' => ['CodAs' => 'CodAs'],
            ],
        ])
        ->methods(['GET']);

    $routes->add('assunto_edit', '/assunto/{CodAs}/edit')
        ->controller([AssuntoController::class, 'edit'])
        ->defaults([
            '_entity' => [
                'mapping' => ['CodAs' => 'CodAs'],
            ],
        ])
        ->methods(['GET', 'POST']);

    $routes->add('assunto_delete', '/assunto/{CodAs}')
        ->controller([AssuntoController::class, 'delete'])
        ->defaults([
            '_entity' => [
                'mapping' => ['CodAs' => 'CodAs'],
            ],
        ])
        ->methods(['POST']);

    // Rotas Autor
    $routes->add('autor_index', '/autor')
        ->controller([AutorController::class, 'index'])
        ->methods(['GET']);

    $routes->add('autor_new', '/autor/new')
        ->controller([AutorController::class, 'new'])
        ->methods(['GET', 'POST']);

    $routes->add('autor_show', '/autor/{CodAu}')
        ->controller([AutorController::class, 'show'])
        ->methods(['GET']);

    $routes->add('autor_edit', '/autor/{CodAu}/edit')
        ->controller([AutorController::class, 'edit'])
        ->methods(['GET', 'POST']);

    $routes->add('autor_delete', '/autor/{CodAu}')
        ->controller([AutorController::class, 'delete'])
        ->methods(['POST']);

    // Rotas Relatórios
    $routes->add('relatorio_pdf_livros', '/livros/relatorio/pdf')
        ->controller([RelatorioController::class, 'gerarPdfLivros'])
        ->methods(['GET']);
};
