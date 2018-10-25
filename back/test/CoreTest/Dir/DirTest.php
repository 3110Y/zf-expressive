<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 27.04.18
 * Time: 17:43
 */

namespace CoreTest\Dir\Tests;

use Core\Dir\Dir;
use PHPUnit\Framework\TestCase;

/**
 * Class DirTest
 * @package Core\Dir\Tests
 */
class DirTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testSetAndGet(): void
    {
        $key = 'testDir';
        $value = 'file/'.uniqid('cache',true);
        $dir = new Dir();
        $dir->set($key, $value);
        $storedLogger = $dir->get($key);
        $this->assertSame($value, $storedLogger);
        rmdir($dir->get($key, true));
    }

    /**
     * @throws \Exception
     */
    public function testSetAndGetAbsolute(): void
    {
        $key = 'testDirSetAndGetAbsolute';
        $dir = new Dir();
        $dir->set($key);
        $storedLogger = $dir->get($key);
        $this->assertSame($key, $storedLogger);
        rmdir($dir->get($key, true));
    }

    /**
     * notice @runInSeparateProcess here: without it, a previous test might have set it already and
     * testing would not be possible. That's why you should implement Dependency Injection where an
     * injected class may easily be replaced
     *
     * @runInSeparateProcess
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWhenTryingToGetNotSetKey(): void
    {
        $dir = new Dir();
        $dir->get('testDirThrowsExceptionWhenTryingToGetNotSetKey');
    }
}