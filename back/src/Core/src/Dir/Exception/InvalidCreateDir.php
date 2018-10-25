<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 08.05.18
 * Time: 13:52
 */

namespace Core\Dir\Exception;


class InvalidCreateDir extends \InvalidArgumentException
{
    private $key;

    public function __construct(string $key)
    {
        parent::__construct('Can`t create folder');
        $this->key          = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}