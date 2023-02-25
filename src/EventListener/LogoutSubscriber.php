<?php 

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutSubscriber extends AbstractController implements EventSubscriberInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) 
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $this->addFlash(
            'success',
            'Vous êtes désormais déconnecté.'
        );

        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_login'),
            RedirectResponse::HTTP_SEE_OTHER
        );
        $event->setResponse($response);
    }
}
