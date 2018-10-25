<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 21.09.18
 * Time: 18:48
 */

namespace Core\Http\Response;


use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Response;

class FileResponse extends Response
{

    /**
     * FileResponse constructor.
     * @param string|resource|StreamInterface $body
     * @param string $name
     * @param int $status
     * @param array $headers
     */
    public function __construct($body = 'php://memory', $name = 'file', $status = 200, array $headers = [])
    {
        if (!($body instanceof StreamInterface)) {
            $body = new FileStream($body, 'resource');
        }
        if (!isset($headers['Content-Disposition'])) {
            $headers['Content-Disposition'] = "attachment; filename='{$name}'";
        }
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/octet-stream; charset=utf-8';
        }
        parent::__construct($body, $status, $headers);
    }
}