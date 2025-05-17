<?php
namespace App\Providers;

use NinjaMutex\Lock\LockAbstract;

class SimpleFileLock extends LockAbstract
{
    protected $dir;
    protected $fpMap = [];

    public function __construct($dir)
    {
        $this->dir = $dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function getLock($name, $timeout = null)
    {
        $lockFile = $this->dir . '/' . md5($name) . '.lock';
        $fp = fopen($lockFile, 'w+');
        if (!$fp) return false;
        $acquired = flock($fp, LOCK_EX | LOCK_NB);
        if ($acquired) {
            $this->fpMap[$name] = $fp;
            return true;
        }
        fclose($fp);
        return false;
    }

    public function releaseLock($name)
    {
        if (isset($this->fpMap[$name])) {
            flock($this->fpMap[$name], LOCK_UN);
            fclose($this->fpMap[$name]);
            unset($this->fpMap[$name]);
        }
        return true;
    }

    public function isLocked($name)
    {
        $lockFile = $this->dir . '/' . md5($name) . '.lock';
        $fp = fopen($lockFile, 'w+');
        if (!$fp) return false;
        $locked = !flock($fp, LOCK_EX | LOCK_NB);
        fclose($fp);
        return $locked;
    }
}