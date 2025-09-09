<?php

namespace App\Validacoes;

class MinhasValidacoes
{
    public function validaCpf(string $cpf, string &$error = null): bool
    {
        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (
            $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' ||
            $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' ||
            $cpf == '88888888888' || $cpf == '99999999999' || strlen($cpf) != 11
        ) {
            $error  = 'Informe um CPF válido';
            return false;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf[$c] != $d) {
                    $error = 'Informe um CPF válido';
                    return false;
                }
            }
            return true;
        }
    }

    public function validaCnh(string $cnh): bool
    {
        // Verifica se tem 11 dígitos numéricos
        if (!preg_match('/^[0-9]{11}$/', $cnh)) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (inválido)
        if (preg_match('/^(\d)\1{10}$/', $cnh)) {
            return false;
        }

        $soma = 0;

        // Primeiro dígito verificador
        for ($i = 0, $j = 9; $i < 9; $i++, $j--) {
            $soma += $cnh[$i] * $j;
        }

        $digito1 = $soma % 11;
        $digito1 = $digito1 >= 10 ? 0 : $digito1;

        // Segundo dígito verificador
        $soma = 0;
        for ($i = 0, $j = 1; $i < 9; $i++, $j++) {
            $soma += $cnh[$i] * $j;
        }

        $digito2 = $soma % 11;
        $digito2 = $digito2 >= 10 ? 0 : $digito2;

        return $cnh[9] == $digito1 && $cnh[10] == $digito2;
    }

    public function validaPlaca(string $placa): bool
    {
        // Remove hífen
        $placa = strtoupper(str_replace('-', '', $placa));

        return (bool) preg_match('/^([A-Z]{3}[0-9]{4}|[A-Z]{3}[0-9][A-Z][0-9]{2})$/', $placa);
    }
}
