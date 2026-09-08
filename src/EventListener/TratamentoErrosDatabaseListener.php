<?php

// src/EventListener/DatabaseExceptionListener.php
namespace App\EventListener;

use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception as DBALException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 10)]
final class TratamentoErrosDatabaseListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof DBALException) {
            return;
        }

        $message = match (true) {
            $throwable instanceof ForeignKeyConstraintViolationException =>
                'Não é possível alterar ou remover este registro pois ele está vinculado a outros itens (autores/assuntos).',

            $throwable instanceof NotNullConstraintViolationException =>
                'Campos obrigatórios no banco não foram preenchidos.',

            $throwable instanceof DriverException =>
                'Não foi possível comunicar com o servidor de banco de dados. Tente novamente.',

            default =>
                'Erro na execução da operação de banco de dados. A ação foi abortada.',
        };

        // 3. Registra a mensagem flash na sessão
        $request = $event->getRequest();
        if ($request->hasSession()) {
            $session = $request->getSession();
            if ($session instanceof FlashBagAwareSessionInterface) {
                $session->getFlashBag()->add('danger', $message);
            }
        }

        $referer = $request->headers->get('referer');
        $targetUrl = $referer ?: $this->urlGenerator->generate('livro_index');

        $event->setResponse(new RedirectResponse($targetUrl));
    }
}