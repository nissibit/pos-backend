<?php

namespace App\Helpers;

class NumberToWords
{
    /**
     * Converte um número em extenso para Metical Moçambicano (MZN).
     *
     * @param float|int|string $valor O valor numérico a ser convertido.
     * @param bool $mostrarCentavos Incluir a parte decimal (centavos/cêntimos).
     * @return string O valor por extenso.
     */
    public static function convert($valor, bool $mostrarCentavos = true): string
    {
        // 1. Array com os nomes dos números/escalas (ajustados ao Português de Moçambique/padrão)
        $unidades = [
            'zero', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'
        ];
        $dezenas = [
            'dez', 'onze', 'doze', 'treze', 'catorze', 'quinze', 'dezasseis', 'dezassete', 'dezoito', 'dezanove'
        ];
        $dezenaDez = [
            null, null, 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'
        ];
        $centenas = [
            null, 'cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'
        ];
        $milhares = [
            ['', 'mil', 'milhão', 'mil milhões', 'bilião', 'mil biliões', 'trilião', 'mil triliões'], // Escalas (singular)
            ['', 'mil', 'milhões', 'mil milhões', 'biliões', 'mil biliões', 'triliões', 'mil triliões']  // Escalas (plural)
        ];

        // 2. Preparação do valor
        $valor = number_format((float)$valor, 2, '.', ''); // Formata para 2 casas decimais

        // Separa a parte inteira (Metical) e a parte decimal (Centavos)
        [$inteiro, $centavos] = explode('.', $valor);

        // Funções auxiliares para processamento de grupos de 3 dígitos
        $processarGrupo = function (int $n) use ($unidades, $dezenas, $dezenaDez, $centenas): string {
            if ($n === 0) return '';

            $c = floor($n / 100);
            $d = floor(($n % 100) / 10);
            $u = $n % 10;
            $extenso = [];

            if ($c > 0) {
                // Se a centena for 100 e a dezena/unidade for zero, usa-se 'cem'
                $extenso[] = ($c === 1 && ($d + $u) === 0) ? 'cem' : $centenas[$c];
            }

            if ($d > 1) {
                $extenso[] = $dezenaDez[$d];
                if ($u > 0) $extenso[] = $unidades[$u];
            } elseif ($d === 1) {
                $extenso[] = $dezenas[$u];
            } elseif ($u > 0) {
                $extenso[] = $unidades[$u];
            }

            return implode(' e ', array_filter($extenso));
        };

        // 3. Processamento da parte inteira (Metical)
        $grupos = str_split(str_pad($inteiro, ceil(strlen($inteiro) / 3) * 3, '0', STR_PAD_LEFT), 3);
        $extensoInteiro = [];
        $grupos = array_map('intval', $grupos);

        foreach (array_reverse($grupos) as $i => $grupo) {
            if ($grupo === 0) continue;

            $extensoGrupo = $processarGrupo($grupo);

            if ($i > 0) { // Aplica a escala de milhar, milhão, etc.
                // Verifica singular/plural da escala (milhar é sempre "mil")
                $escala = ($grupo === 1) ? $milhares[0][$i] : $milhares[1][$i];

                // Se o grupo é 'um' e a escala é 'milhão', usa-se 'um milhão'
                if ($grupo === 1 && $escala !== 'mil') {
                    $extensoInteiro[] = ($i === 2) ? 'um ' . $escala : 'uma ' . $escala; // um milhão / um bilião, etc.
                } elseif ($grupo > 1 && $escala !== 'mil') {
                    $extensoInteiro[] = $extensoGrupo . ' ' . $escala;
                } elseif ($escala === 'mil') { // "mil" não precisa do número, exceto se for maior que 1000
                    if ($grupo === 1) {
                         $extensoInteiro[] = 'mil';
                    } else {
                         $extensoInteiro[] = $extensoGrupo . ' mil';
                    }
                }
            } else {
                 $extensoInteiro[] = $extensoGrupo;
            }
        }

        $extensoInteiro = implode(' ', array_reverse($extensoInteiro));

        // 4. Formatação final da moeda
        $moedaSingular = 'Metical';
        $moedaPlural = 'Meticais';

        $extensoFinal = $extensoInteiro;

        // Adicionar o nome da moeda
        if (intval($inteiro) === 1) {
            $extensoFinal .= ' ' . $moedaSingular;
        } else {
            $extensoFinal .= ' ' . $moedaPlural;
        }

        // 5. Processamento dos centavos
        if ($mostrarCentavos && $centavos > 0) {
            $centavosInteiro = intval($centavos);

            // Reutiliza a função de processamento para os centavos (parte de 100)
            $extensoCentavos = $processarGrupo($centavosInteiro);

            // Adiciona a ligação "e"
            $extensoFinal .= ' e ';

            // Adiciona a parte decimal e o nome
            $centavosNome = ($centavosInteiro === 1) ? 'centavo' : 'centavos'; // Padrão Moçambicano, ou usar 'centavo(s)'
            $extensoFinal .= $extensoCentavos . ' ' . $centavosNome;
        }

        // Se o valor for zero
        if ($inteiro === '0' && $centavos === '00') {
            return $unidades[0] . ' ' . $moedaPlural;
        }

        return ucfirst($extensoFinal);
    }
}
