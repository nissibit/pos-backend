<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit;
use OwenIt\Auditing\Contracts\Auditable;

class Base extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;
    
    public static function strPart($string) {
        if (strlen($string) > 30) {
            return (substr($string, 0, 12) . " ...");
        } else {
            return $string;
        }
    }

    public static function addDays($carbon) {
        $timestamp = new \DateTime($carbon);
        $dt = Carbon::createFromTimestamp($timestamp->getTimestamp());
        if ($dt->addDay()->isSaturday()) {
            $dt = $dt->next(Carbon::MONDAY);
        }
        return $dt->toDateString();
    }

    public static function addWeeks($carbon) {
        $timestamp = new \DateTime($carbon);
        $dt = Carbon::createFromTimestamp($timestamp->getTimestamp());
        if ($dt->addWeek()->isSaturday()) {
            $dt = $dt->next(Carbon::MONDAY);
        }
        return $dt->toDateString();
    }

    public static function addMonths($carbon, $Nr = 1) {
        $timestamp = new \DateTime($carbon);
        $dt = Carbon::createFromTimestamp($timestamp->getTimestamp());
        if ($dt->addMonths($Nr)->isSaturday()) {
            $dt = $dt->next(Carbon::MONDAY);
        }
        return $dt->toDateString();
    }

    public static function dataPrestacao($data, $type) {
        if ($type === "Diario") {
            return Base::addDays($data);
        }
        if ($type === "Semanal") {
            return Base::addWeeks($data);
        }
        if ($type === "Mensal") {
            return Base::addMonths($data, 1);
        }
        if ($type === "Bimestral") {
            return Base::addMonths($data, 2);
        }
        if ($type === "Trimestral") {
            return Base::addMonths($data, 3);
        }
        if ($type === "Quadrimestral") {
            return Base::addMonths($data, 4);
        }
        if ($type === "Semestral") {
            return Base::addMonths($data, 6);
        }
        if ($type === "Anual") {
            return Base::addMonths($data, 12);
        }
    }

    #Controlar consultas

    public static function addEvent($param, $event = 'query') {
        $audit = new Audit();
        $audit->event = $event;
        $audit->save();
    }

    public static function nomeMes($mes) {
        switch ($mes) {
            case 1: return "Janeiro";
            case 2: return "Fevereiro";
            case 3: return "Marco";
            case 4: return "Abril";
            case 5: return "Maio";
            case 6: return "Junho";
            case 7: return "Julho";
            case 8: return "Agosto";
            case 9: return "Setembro";
            case 10: return "Outubro";
            case 11: return "Novembro";
            case 12: return "Dezembro";

            default: "Desconhecido";
        }
    }

    public static function tipoDoc() {
        return ['BI', 'Passaporte', 'Talao', 'DIRE'];
    }

    public static function nivelAcademico() {
        return ['12ª Classe do Sistema Nacional de Educação (SNE)', 'Ensino Técnico Profissional', 'Equivalente'];
    }

    public static function grauParentesco() {
        return ['Pai', 'Mae', 'Avo', 'Irma(ao)', 'Filho(a)', 'Neto(a)', 'Esposo(a)', 'Outro(a)'];
    }

    public static function entidades() {
        return ['Matricula-Colegio' => 15004, 'Multa-Colegio' => 15005, 'Matricula-Centro' => 14001, "Multa-Centro" => 14002];
    }

    public static function tipoEntidadeBancaria() {
        return ['Normal', 'Multa', 'Adiantamento'];
    }

    /* Caso para facturas */

    //Replac de moeda
    public static function replaceMoeda($pr) {
        $pr = str_replace(".", "", $pr);
        $pr = str_replace("MT", "", $pr);
        $pr = str_replace(",", "", $pr);
        $pr = str_replace(" ", "", $pr);
        return $pr;
    }

    public static function replaceMoeda02($pr) {
        $pr = str_replace("MT", "", $pr);
        $pr = str_replace(",", "", $pr);
        $pr = str_replace(" ", "", $pr);
        return $pr;
    }

    //Nr do mes com duas casas decimais
    public static function nrMes($nr) {
        return str_pad($nr, 2, '0', 0);
    }

#funcao que prenche por zeros
    /*
     * * Completa os números
     * @param int $nr - Número que se pretende completar
     * @param int $qtd - Quantidade de digitos requeridos
     * @param string $ch - Caracter qe vai preencher os que estiverem em falta
     * @param string $l - Escolher o lado que se apresentarão os caracteres
     * @return string
     */

    public static function completaNr($nr, $qtd, $ch, $l) {
        return str_pad($nr, $qtd, $ch, $l);
    }

// check digit
    public static function checkDigit($nr) {
        $num = strlen($nr) - 1;
        $Pi = 0;
        $array = array();
        while ($num >= 0) {
            array_unshift($array, $nr[$num]);
            $num--;
        }
        foreach ($array as $ar) {
            #echo $ar;
            $Si = (int) $ar + $Pi;
            $Pi = ($Si * 10) % 97;
        }
        $Pn = ($Pi * 10) % 97;
        $CD = self::nrMes(98 - $Pn);
        return $CD;
    }

    #Funcoes para carregamento:

    public static function tipoRegisto($linha) {
        $reg = "";
        $tipo = "" . substr($linha, 0, 1);
        switch ($tipo) {
            case '0': $reg = "HEADER";
                Break;
            case '1': $reg = "DETALHE";
                Break;
            case '2': $reg = "DETALHE";
                Break;
            case '9': $reg = "TRAILER";
                Break;
            default: $reg = "Desconhecido";
        }
        return $reg;
    }

    public static function cabeca($linha) {
        $resposta = array(
            "line" => $linha,
            "record_type" => substr($linha, 0, 1),
            "file_type" => "BMEPS",
            "from_id" => "N/A",
            "to_id" => "N/A",
            "date" => substr($linha, 10, 4) . "-" . substr($linha, 8, 2) . "-" . substr($linha, 6, 2),
            "last_file_id" => substr($linha, 14, 18),
            "entity" => substr($linha, 1, 5),
            "currency" => "N/A",
            "rate" => "N/A",
            "log_id" => "N/A",
        );
        return $resposta;
    }

    #Cabeca 2 pra leitura de MEPS

    public static function cabeca_2($linha) {
        $resposta = array(
            "line" => $linha,
            "record_type" => substr($linha, 0, 1),
            "file_type" => substr($linha, 1, 4),
            "from_id" => substr($linha, 5, 8),
            "to_id" => substr($linha, 13, 8),
            "date" => substr($linha, 21, 9),
            "last_file_id" => substr($linha, 30, 9),
            "entity" => substr($linha, 39, 5),
            "currency" => substr($linha, 44, 3),
            "rate" => substr($linha, 47, 2),
            "log_id" => substr($linha, 49, 4),
        );
        return $resposta;
    }

    public static function detalhe($linha) {
        $resposta = array(
            'line' => $linha,
            'record_type' => substr($linha, 0, 1),
            'processing_code' => "N/A",
            'log_id' => "N/A",
            'log_number' => "N/A",
            'datetime' => substr($linha, 48, 4) . "-" . substr($linha, 46, 2) . "-" . substr($linha, 44, 2) . " " . substr($linha, 52, 2) . ":" . substr($linha, 54, 2),
            'amount' => substr($linha, 12, 14) . "." . substr($linha, 26, 2),
            'comission' => substr($linha, 28, 14) . "." . substr($linha, 42, 2),
            'terminal_type' => "N/A",
            'terminal_id' => "N/A",
            'transaction_id' => "N/A",
            'terminal_place' => "N/1",
            'reference' => substr($linha, 1, 11),
            'sent_mode' => "N/A",
            'answer_cod' => "N/A",
            'answer_number' => "N/A",
        );
        return $resposta;
    }

    #Detalhe para a leitura do ficheiro MEPS

    public static function detalhe_2($linha) {
        $resposta = array(
            'line' => $linha,
            'record_type' => substr($linha, 0, 1),
            'processing_code' => substr($linha, 1, 2),
            'log_id' => substr($linha, 3, 4),
            'log_number' => substr($linha, 7, 8),
            'datetime' => substr($linha, 15, 4) . "-" . substr($linha, 19, 2) . "-" . substr($linha, 21, 2) . " " . substr($linha, 23, 2) . ":" . substr($linha, 25, 2),
            'amount' => substr($linha, 27, 11) . "." . substr($linha, 38, 2),
            'comission' => substr($linha, 40, 7) . "." . substr($linha, 47, 2),
            'terminal_type' => substr($linha, 49, 2),
            'terminal_id' => substr($linha, 51, 10),
            'transaction_id' => substr($linha, 61, 5),
            'terminal_place' => substr($linha, 66, 15),
            'reference' => substr($linha, 81, 11),
            'sent_mode' => substr($linha, 92, 1),
            'answer_cod' => substr($linha, 93, 1),
            'answer_number' => substr($linha, 94, 12),
        );
        return $resposta;
    }

    public static function rodape($linha) {
        $resposta = array(
            "line" => $linha,
            "record_type" => substr($linha, 0, 1),
            "number_records" => substr($linha, 1, 7),
            "amount_sum" => substr($linha, 8, 14) . "." . substr($linha, 22, 2),
            "rate_sum" => substr($linha, 24, 14) . "." . substr($linha, 38, 2),
            "iva" => 0,
        );
        return $resposta;
    }

    #Rodape para MEPS    

    public static function rodape_2($linha) {
        $resposta = array(
            "line" => $linha,
            "record_type" => substr($linha, 0, 1),
            "number_records" => substr($linha, 1, 8),
            "amount_sum" => substr($linha, 9, 15) . "." . substr($linha, 24, 2),
            "rate_sum" => substr($linha, 26, 12),
            "iva" => substr($linha, 38, 10) . "." . substr($linha, 48, 2),
        );
        return $resposta;
    }

    public static function tipoFicheiro() {
        return array("MEPS", "BMEPS");
    }

    #Tipo de tipos de Multa

    public static function modeTipoMulta() {
        return array("Percentagem", "Valor");
    }

    #Tipo de profissao

    public static function tipoProfissao() {
        return array("Estudante", "outra");
    }

    #Tipo de profissao

    public static function tipoNacionalidade() {
        return array("Moçambicana", "Estrangeiro[a]");
    }
    
    public static function tipoCliente() {
        return array("Singular", "Empresa");
    }
    
    public static function tipoFornecedor() {
        return array("Singular", "Empresa");
    }
   
    public static function meioPagamento() {
        return array("Cash", "Transferencia UNICO", "Transferencia BIM", "Transferencia BCI", "POS UNICO", "POS BIM", "POS BCI ","Cheque");
    }

    public static function anos($mais = 0) {
        $anos = array();
        for ($i = date("Y") + $mais; $i >= 2019; $i--) {
            array_push($anos, $i);
        }
        return $anos;
    }

    #Leitura do ficheiro MEPS
    #Lista de Models

    public static function models() {
//        $path = app_path() . "\Models";
        $path = app_path() . "/Models";
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') {
                continue;
            }
//            $key = $path . '\\' . $result;
            $key = '\\App\\Models\\' . $result;
            $filename = $result;
            if (is_dir($filename)) {
                $out = array_merge($out, getModels($filename));
            } else {
                $out[substr($key, 0, -4)] = substr($filename, 0, -4);
            }
        }
        #dd($out);
        return $out;
    }

    public static function estadoCIvil() {
        return [
            'Solteiro' => 'Solteiro',
            'Casado' => [
                'Casado Tradicional' => 'Tradicional',
                'Casado Religioso' => 'Religioso',
                'Casado Civil' => 'Civil'
            ],
            'Divorciado' => 'Divorciado',
            'Viuvo' => 'Viuvo',
        ];
    }
    public static function arquivoCIvil() {
        return [
            'Maputo',
            'Matola',
            'Xai-Xai',
            'Inhambane',
            'Beira',
            'Manica',
            'Tete',
            'Quelimane',
            'Nampula',
            'Lichinga',
            'Pemba',
            'Outro(a)',
        ];
    }
    
    public static function cashFlowType() {
        return ['Entrada', 'Saida'];
    }
    
    public static function reasonCreditNote() {
        return ["DEVOLUCAO", "DANIFICADO", "OUTRO"];
    }
}
