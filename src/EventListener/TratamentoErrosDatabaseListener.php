<?php

namespace App\EventListener;

use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Exception\DeadlockException;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\LockWaitTimeoutException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 10)]
final class TratamentoErrosDatabaseListener
{

    //001-DriverException -> Erro de conexão com banco
    //002-DeadlockException/LockWaitTimeoutException -> Erro de muitas requisições simultaneas

    public function __construct(private LoggerInterface $logger)
    {
    }
    
    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof DBALException) {
            return;
        }

        if ($throwable instanceof DriverException) {

            $response = new Response();
            $response->setContent('<h1>Sistema indisponível</h1><p>Não foi possível comunicar com o servidor de banco de dados. Tente novamente mais tarde.</p><p style="color:red">Código do Erro: #001</p>');
            $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
            $event->setResponse($response);
            $this->logger->error('Erro de conexão com o banco de dados: ' . $throwable->getMessage());
            return;
        }

        if ($throwable instanceof DeadlockException || $throwable instanceof LockWaitTimeoutException) {

            $response = new Response();
            $response->setContent('<h1>Sistema Sobrecarregado</h1><p>Ocorreu um erro devido às muitas requisições simultâneas. Tente novamente mais tarde.</p><p style="color:red">Código do Erro: #002</p>');
            $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
            $event->setResponse($response);
            $this->logger->error('Erro de deadlock ou timeout de lock: ' . $throwable->getMessage());
            return;
        }
    }
}
