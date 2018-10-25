<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 17.09.18
 * Time: 19:46
 */

namespace Core\Logger\Middleware;


use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ResponseLoggerMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ResponseLoggerMiddleware constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $code = (int)$response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $data = [
            'method' => $request->getMethod(),
            'url' => (string)$request->getUri(),
        ];
        if (Logger::DEBUG <= $code && $code < Logger::INFO) {
            $this->logger->debug($reasonPhrase, $data);
        } elseif (Logger::INFO <= $code && $code < Logger::NOTICE) {
            $this->logger->info($reasonPhrase, $data);
        } elseif (Logger::NOTICE <= $code && $code < Logger::WARNING) {
            $this->logger->notice($reasonPhrase, $data);
        } elseif (Logger::WARNING <= $code && $code < Logger::ERROR) {
            $this->logger->warning($reasonPhrase, $data);
        } elseif (Logger::ERROR <= $code && $code < Logger::CRITICAL) {
            $this->logger->error($reasonPhrase, $data);
        } elseif (Logger::CRITICAL <= $code && $code < Logger::ALERT) {
            $this->logger->alert($reasonPhrase, $data);
        } elseif (Logger::ALERT <= $code && $code < Logger::EMERGENCY) {
            $this->logger->emergency($reasonPhrase, $data);
        }

        return $response;
    }
}