<?php

namespace App\Services;

use App\Models\EmpresaModel;
use CodeIgniter\I18n\Time;
use App\Models\PedidoModel;

/**
 * Classe de serviço para centralizar as regras de negócio da Empresa.
 */
class EmpresaService
{
    private $empresaModel;
    private $pedidoModel;
    private $empresa = null;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
        $this->pedidoModel = new PedidoModel();
    }

    private function getEmpresa(): ?object
    {
        if ($this->empresa === null) {
            $this->empresa = $this->empresaModel->first();
        }
        return $this->empresa;
    }

    /**
     * Ponto de entrada principal para verificar se a empresa está aberta.
     *
     * @return bool Retorna true se a empresa estiver aberta, caso contrário, false.
     */
    public function estaAberta(): bool
    {
        $empresa = $this->getEmpresa();
        if (!$empresa) {
            return false;
        }
        $horariosDecodificados = json_decode($empresa->horarios_funcionamento ?? '[]', true);
        return $this->verificarHorario($horariosDecodificados);
    }
    
    /**
     * NOVO MÉTODO
     * Calcula o tempo restante para a próxima abertura da loja.
     *
     * @return array|null Retorna um array com 'mensagem' e 'segundos' ou null se não houver horário.
     */
    public function getDadosProximaAbertura(): ?array
    {
        $empresa = $this->getEmpresa();
        $horarios = json_decode($empresa->horarios_funcionamento ?? '[]', true);

        if (empty($horarios)) {
            return null;
        }

        $diasDaSemana = [
            'monday'    => 'Segunda-feira', 'tuesday'   => 'Terça-feira',
            'wednesday' => 'Quarta-feira',  'thursday'  => 'Quinta-feira',
            'friday'    => 'Sexta-feira',   'saturday'  => 'Sábado',
            'sunday'    => 'Domingo',
        ];

        $agora = Time::now('America/Sao_Paulo'); // Use o seu fuso horário
        
        // Loop por até 7 dias para encontrar a próxima abertura
        for ($i = 0; $i < 7; $i++) {
            
            // CORREÇÃO: Usamos um clone da data original para não modificar a variável $agora
            $diaProcurado = (clone $agora)->addDays($i);
            $diaDaSemanaIngles = strtolower($diaProcurado->format('l'));

            if (isset($horarios[$diaDaSemanaIngles]) && $horarios[$diaDaSemanaIngles] !== 'Fechado' && strpos($horarios[$diaDaSemanaIngles], ' - ') !== false) {
                
                list($inicio, $fim) = explode(' - ', $horarios[$diaDaSemanaIngles]);

                $proximaAbertura = Time::parse(
                    $diaProcurado->format('Y-m-d') . ' ' . $inicio,
                    'America/Sao_Paulo'
                );

                // Se a próxima abertura encontrada já passou, vamos para a próxima iteração
                if ($proximaAbertura->isBefore($agora)) {
                    continue;
                }

                $segundosRestantes = $proximaAbertura->getTimestamp() - $agora->getTimestamp();
                
                // Define uma mensagem mais amigável para o dia
                $diaFormatado = 'em ' . $diasDaSemana[$diaDaSemanaIngles];
                if ($i === 0) $diaFormatado = 'Hoje';
                if ($i === 1) $diaFormatado = 'Amanhã';

                return [
                    'mensagem'  => "Abrimos {$diaFormatado} às {$inicio}",
                    'segundos'  => $segundosRestantes,
                ];
            }
        }
        
        return null; // Caso a loja não abra nos próximos 7 dias
    }


    public function limitePedidosAtingido(): bool
    {
        $empresa = $this->getEmpresa();
        if (!$empresa) {
            return false;
        }
        $limitePorHora = (int) ($empresa->pedidos_por_hora ?? 0);
        if ($limitePorHora === 0) {
            return false;
        }
        $pedidosNaHora = $this->pedidoModel->contaPedidosNaHoraAtual();
        return $pedidosNaHora >= $limitePorHora;
    }

    private function verificarHorario(array $horarios): bool
    {
        $horaAtual = Time::now();
        $diaAtual = strtolower($horaAtual->format('l'));
        $horaParaComparar = $horaAtual->format('H:i');
        if (!isset($horarios[$diaAtual])) {
            return false;
        }
        $horarioDoDia = $horarios[$diaAtual];
        if ($horarioDoDia === 'Fechado') {
            return false;
        }
        if ($horarioDoDia === 'Aberto 24h') {
            return true;
        }
        if (strpos($horarioDoDia, ' - ') !== false) {
            list($inicio, $fim) = explode(' - ', $horarioDoDia);
            if ($fim < $inicio) {
                return ($horaParaComparar >= $inicio || $horaParaComparar <= $fim);
            } else {
                return ($horaParaComparar >= $inicio && $horaParaComparar <= $fim);
            }
        }
        return false;
    }
}