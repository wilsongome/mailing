<?php
namespace App\Domain\Campaign;
class Campaign{

    /**
     * Na tela de campanhas, criar 3 abas
     * 1) Tela de cadastro com a view existente
     * 2) Tela de lista de contatos, e botão para iniciar o processo
     * 3) Tela de agendamento
     * 
     * O Botão Executar ao ao ser pressionado, vai questionar a execução. 
     * Se for aceito, vai iniciar o processo percorrendolista por lista, validando cada linha e
     * lançando na fila de execução
     * 
     * Depois criar a rotina/job que fará o envio de fato.
     * 
     **/
}
?>