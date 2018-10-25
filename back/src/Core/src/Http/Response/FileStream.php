<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 21.09.18
 * Time: 18:47
 */

namespace Core\Http\Response;


use Zend\Diactoros\Stream;

/**
 * Class FileStream
 * @package Core\Http
 */
class FileStream extends Stream
{


    /**
     * @param $filename
     * @param $mode
     * @param bool $use_include_path
     * @param null $context
     * @return FileStream
     * @throws \ErrorException
     */
    public static function create($filename, $mode, $use_include_path = false, $context = null): FileStream
    {
        /** @var resource $resource */
        /** @noinspection ReturnFalseInspection */
        $resource = fopen($filename, $mode, $use_include_path, $context);
        if (false === $resource) {
            throw new \ErrorException('File no exist', 500);
        }
        if(\is_resource($context)) {
            return new self($resource);
        }
        return new static($resource);
    }
}