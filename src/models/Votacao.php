<?php

namespace Models;

require 'vendor/autoload.php';

use Config\Redis;
use Exception;

class Votacao
{
    public $uuid;
    public $titulo;
    public $data_inicio;
    public $data_fim;

    public function __construct($titulo = null, $data_inicio = null, $data_fim = null)
    {
        $this->uuid = uniqid();
        $this->titulo = $titulo;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    function criarVotacao()
    {
        try {
            $redisConfig = new Redis();
            $redis = $redisConfig->getConnection();

            $redis->hmset("votacao:{$this->uuid}", [
                'uuid' => $this->uuid,
                'titulo' => $this->titulo,
                'data_inicio' => $this->data_inicio,
                'data_fim' => $this->data_fim
            ]);

            $response = [
                'success' => true,
                'message' => 'Votação criada com sucesso!',
                'uuid' => $this->uuid
            ];

            echo json_encode($response);
        } catch (Exception $err) {
            // Registre a exceção em um arquivo de log ou outro mecanismo de registro
            error_log($err->getMessage());

            // Retorne uma mensagem de erro genérica
            $response = [
                'success' => false,
                'message' => 'Ocorreu um erro ao criar a votação. Por favor, tente novamente mais tarde.'
            ];

            return json_encode($response);
        }
    }

    public function pegarVotacoes()
    {
        try {
            $redisConfig = new Redis();
            $redis = $redisConfig->getConnection();

            $keys = $redis->keys("votacao:*");

            $votacoes = [];

            foreach ($keys as $key) {
                $votacaoData = $redis->hgetall($key);

                $votacoes[] = $votacaoData;
            }

            echo json_encode($votacoes);

        } catch (Exception $err) {
            error_log($err->getMessage());

            return false;
        }
    }
}
