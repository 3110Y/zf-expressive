<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 26.07.18
 * Time: 14:27
 */

namespace Core\Http\File;

use Psr\Http\Message\ServerRequestInterface;

interface RequestFactoryInterface
{
    public function __invoke(): ServerRequestInterface;
}