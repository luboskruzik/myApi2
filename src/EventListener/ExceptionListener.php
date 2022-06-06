<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener 
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        
        $response = new JsonResponse();
        $response->setData(['message' => $exception->getMessage()]);

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
