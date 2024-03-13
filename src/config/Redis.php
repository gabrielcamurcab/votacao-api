<?php

namespace Config;

require 'vendor/autoload.php';

use Predis\Client;
use Dotenv\Dotenv;

class Redis {
    protected $redis;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__, '../../');
        $dotenv->load();

        $redisHost = $_ENV['REDIS_HOST'];
        $redisPort = $_ENV['REDIS_PORT'];

        $this->redis = new Client([
            'host' => $redisHost,
            'port' => $redisPort
        ]);
    }

    public function getConnection() {
        return $this->redis;
    }
}