<?php

class MyCache extends \MyApp
{
    private $pool;
    private $ttl = 3600; // 3600 detik == 1 jam

    public function __construct() {
        parent::__construct();

        $options = array('path' => APP_DIR . '/cache/');
        $driver = new \Stash\Driver\FileSystem($options);

        $this->pool = new \Stash\Pool($driver);
    }

    public function set($data, $key, $ttl) {
        if (empty($ttl)) {
            $ttl = $this->ttl;
        }

        $item = $this->pool->getItem($key);

        if (is_array($data)) {
            $data = json_encode($data);
        }
        $item->set($data);

        // Cache expires in one hour.
        $item->expiresAfter($ttl);

        $this->pool->save($item);

        return $data;
    }

    public function get($key) {
        $item = $this->pool->getItem($key);

        $data = $item->get();

        if ($this->isJson($data)) {
            return json_decode($data, true);
        }

        return $data;
    }

    public function del($key) {
        $this->pool->deleteItem($key);

        return true;
    }


    private function isJson($json) {
        $result = json_decode($json);

        if (json_last_error() === JSON_ERROR_NONE) {
            return true; // JSON is valid
        }

        return false;
    }

}
