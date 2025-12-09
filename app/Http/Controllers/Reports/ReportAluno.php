<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use PDF;
use App\Models\Matricula;

class ReportAluno extends Controller {

    function __construct() {
        $this->middleware("auth");
    }

    public function extracto(Matricula $id) {
        #dd($id);
        $matricula = $id->load('turma', 'entidade', 'taxas', 'entidade', 'facturas');
        if ($matricula == null) {
            return redirect()->back()->with('info', 'Código da matrícula invávalido.');
        }
        $entidade = $matricula->entidade;
        $pdf = PDF::loadView("report.aluno.extracto", compact("matricula"));
        #dd($pdf);
        return $pdf->download("Extracto_do_Aluno_{$entidade->firstname}_{$entidade->lastname}.pdf");
    }

}
