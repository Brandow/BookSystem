<?php

namespace App\Tests;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class Conexao extends KernelTestCase
{
    public function testConexaoComBanco(): void
    {
        self::bootKernel();

        /** @var Connection $connection */
        $connection = static::getContainer()->get(Connection::class);

        $resultado = $connection->executeQuery('SELECT 1')->fetchOne();

        $this->assertEquals(1, $resultado, 'Não foi possível conectar ao banco de dados.');
    }
}