<?php

namespace App\EventSubscriber;

use App\Exception\BadRequestWithErrorsHttpException;
use App\FormRequest\FormRequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FormRequestSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'validateFormRequest',
        ];
    }

    public function validateFormRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!($request instanceof FormRequestInterface) || $request->isValid()) {
            return;
        }

        throw new BadRequestWithErrorsHttpException($request->getErrors());
    }
}
