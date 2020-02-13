<?php


namespace App\Controller\Work;


use Psr\Log\LoggerInterface;

class ErrorHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(\DomainException $e)
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}