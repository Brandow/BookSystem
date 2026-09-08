<?php

namespace App\Tests;

use App\Entity\Autor;
use App\Entity\Livro;
use PHPUnit\Framework\TestCase;

class AutorTest extends TestCase
{
    public function testQtdLivros(){

    $autor = new Autor();
    $livro1 = new Livro();
    $livro2 = new Livro();

    $autor->addLivro($livro1);
    $autor->addLivro($livro2);

    $this->assertEquals(2, $autor->getQtdLivros());

    }

}
