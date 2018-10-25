<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 26.09.18
 * Time: 18:01
 */

namespace CoreTest\Logger\Factory;


use Core\Logger\Factory\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    /** @var ContainerInterface|DummyContainer */
    protected $container;

    protected function setUp()
    {
        $this->container = new DummyContainer();
    }

    public function testInvoke() :void
    {
        $factory = (new LoggerFactory())($this->container);

        $this->assertInstanceOf(LoggerInterface::class, $factory);
    }
}

class DummyContainer implements ContainerInterface
{
    public $debug = false;

    public function get($id)
    {
        return [
            'debug' => $this->debug
        ];
    }

    public function has($id): bool
    {
        return true;
    }
}
