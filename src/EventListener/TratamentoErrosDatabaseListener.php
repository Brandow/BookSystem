<?php

namespace App\EventListener;

use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception as DBALException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 10)]
final class TratamentoErrosDatabaseListener
{

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof DBALException) {
            return;
        }

        if ($throwable instanceof DriverException) {
            $html = '<h1>Sistema temporariamente indisponível</h1><p>Não foi possível comunicar com o servidor de banco de dados. Tente novamente mais tarde.</p>';
            $event->setResponse(new Response($html, Response::HTTP_SERVICE_UNAVAILABLE));
            return;
        }
    }
}