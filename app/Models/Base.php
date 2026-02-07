<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Base
{

    use \OwenIt\Auditing\Auditable;

    public static function strPart($string)
    {
        if (strlen($string) > 30) {
            return (substr($string, 0, 12) . " ...");
        } else {
            return $string;
        }
    }

    public static function nomeMes($mes)
    {
        switch ($mes) {
            case 1:
                return "Janeiro";
            case 2:
                return "Fevereiro";
            case 3:
                return "Marco";
            case 4:
                return "Abril";
            case 5:
                return "Maio";
            case 6:
                return "Junho";
            case 7:
                return "Julho";
            case 8:
                return "Agosto";
            case 9:
                return "Setembro";
            case 10:
                return "Outubro";
            case 11:
                return "Novembro";
            case 12:
                return "Dezembro";

            default:
                "Desconhecido";
        }
    }

    public static function tipoCliente()
    {
        return array("Singular", "Empresa");
    }

    public static function tipoFornecedor()
    {
        return array("Singular", "Empresa");
    }

    public static function meioPagamento()
    {
        return array("Cash", "Transferencia UNICO", "Transferencia BIM", "Transferencia BCI", "POS UNICO", "POS BIM", "POS BCI ", "Cheque");
    }

    public static function anos($mais = 0)
    {
        $anos = array();
        for ($i = date("Y") + $mais; $i >= 2019; $i--) {
            array_push($anos, $i);
        }
        return $anos;
    }

    public static function cashFlowType()
    {
        return ['Entrada', 'Saida'];
    }

    public static function reasonCreditNote()
    {
        return ["DEVOLUCAO", "DANIFICADO", "OUTRO"];
    }
}
