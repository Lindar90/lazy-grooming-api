<?php

namespace App\EventSubscriber;

use App\Exception\BadRequestWithErrorsHttpException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['handleExceptions', 10],
        ];
    }

    public function handleExceptions(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();

        $statusCode = $exception instanceof HttpException ?
            $exception->getStatusCode()
            : 500;

        $data = [
            'message' => 'Something went wrong',
        ];

        $response->setStatusCode($statusCode);

        if ($exception instanceof BadRequestWithErrorsHttpException) {
            $data = [
                'errors' => $exception->errors,
            ];
        }

        $response->setData($data);

        $event->setResponse($response);
    }
}
