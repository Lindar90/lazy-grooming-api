<?php

namespace App\EventSubscriber;

use App\Exception\BadRequestWithErrorsHttpException;
use App\FormRequest\FormRequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FormRequestSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'validateFormRequest',
        ];
    }

    public function validateFormRequest(ControllerArgumentsEvent $event)
    {
        $arguments = array_values($event->getNamedArguments());

        array_walk(
            $arguments,
            function ($argument) {
                if (!($argument instanceof FormRequestInterface) || $argument->isValid()) {
                    return;
                }

                throw new BadRequestWithErrorsHttpException($argument->getErrors());
            }
        );
    }
}
