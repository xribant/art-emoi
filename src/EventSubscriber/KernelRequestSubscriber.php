<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment as TwigEnvironment;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    private TwigEnvironment $twig;
    protected $requestStack;

    public function __construct(TwigEnvironment $twig, RequestStack $requestStack)
    {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onMaintenance', \PHP_INT_MAX - 1000],
            ],
        ];
    }

    public function onMaintenance(RequestEvent $event): void
    {
        /** @var bool $isMaintenance */
        $isMaintenance = \filter_var($_ENV['MAINTENANCE_MODE'] ?? '0', \FILTER_VALIDATE_BOOLEAN);
        $isCli = \PHP_SAPI === 'cli';
        $ip = $this->requestStack->getCurrentRequest()->getClientIp();

        if ($ip !== $_ENV['MAINTENANCE_AUTHORIZED_IP']) {
            if ($isMaintenance && !$isCli) {
                $event->setResponse(new Response(
                    $this->twig->render('maintenance/maintenance.html.twig'),
                    Response::HTTP_SERVICE_UNAVAILABLE,
                ));
                $event->stopPropagation();
            }
        }
    }
}