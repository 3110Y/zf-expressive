<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 27.04.18
 * Time: 15:37
 */
namespace Core\Dir;


use Core\Dir\Exception\InvalidCreateDir;


/**
 * Class Dir
 * @package Core\Dir
 */
class Dir
{
    /**
     * @var string DOCUMENT ROOT
     */
    private $DR = '';

    /**
     * this introduces global state in your application which can not be mocked up for testing
     * and is therefor considered an anti-pattern! Use dependency injection instead!
     *
     * @var array
     */
    private  $storedValues = [];


    /**
     * Устанавливает DOCUMENT ROOT;
     * @param string $DR DOCUMENT ROOT
     */
    public function setDR(string $DR = __DIR__): void
    {
        $this->DR  =   str_replace('\\', DIRECTORY_SEPARATOR, $DR);
    }

    /**
     * Отдает DOCUMENT ROOT
     * @param bool $notSlash
     *
     * @return string DOCUMENT ROOT;
     */
    public function getDR($notSlash = false): string
    {
        if ($this->DR !== '') {
            if ($notSlash) {
                return $this->DR;
            }
            return $this->DR . '/';

        }
        if (isset($_SERVER['DOCUMENT_ROOT'])) {
            return $_SERVER['DOCUMENT_ROOT'];
        }
        return str_replace(array('src\Core', '\\'), array('', '/'), __DIR__);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     * @throws Exception\InvalidCreateDir
     */
    public function set(string $key, $value = '') :void
    {
        if ($value === '') {
            $value  =   $key;
        }
        if ($this->has($key)) {
            throw new \InvalidArgumentException('Key exist');
        }
        $this->storedValues[$key] = $value;
        $dirAbsolute    =   $this->get($key, true);
        if (!file_exists($dirAbsolute) && !mkdir($dirAbsolute, 0777, true) && !is_dir($dirAbsolute)) {
            throw new InvalidCreateDir($key);
        }
    }

    /**
     * @param string $key
     *
     * @param bool $needAbsolute
     * @param bool $notSlash
     *
     * @return mixed
     */
    public function get(string $key, $needAbsolute = false, $notSlash = true)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException('Key not exist');
        }
        $dir    =   $this->storedValues[$key];
        if (!$notSlash) {
            $dir .= '/';
        }
        if ($needAbsolute) {
            return  $this->getDR()   .   $dir;
        }
        return  $dir;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public  function has(string $key): bool
    {
        return isset($this->storedValues[$key]);
    }

}