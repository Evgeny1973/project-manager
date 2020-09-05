<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\ErrorHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var ErrorHandler
     */
    private $errors;
    
    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
    
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();
        $request = $event->getRequest();
        
        if (!$exception instanceof \DomainException) {
            return;
        }
        
        if (strpos($request->attributes->get('_route'), 'api.') !== 0) {
            return;
        }
        
        $this->errors->handle($exception);
    
        $event->setResponse(new JsonResponse([
            'error' => [
                'code'    => 400,
                'message' => $exception->getMessage(),
            ],
        ], 400));
    }
}
