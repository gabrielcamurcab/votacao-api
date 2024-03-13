<?php

namespace Controllers;

require 'vendor/autoload.php';

use Models\Votacao;

class VotacaoController {
    public function criarVotacao() {
        $data = json_decode(file_get_contents("php://input"), true);

        $votacao = new Votacao($data['titulo'], $data['data_inicio'], $data['data_fim']);

        return $votacao->criarVotacao();
    }
}