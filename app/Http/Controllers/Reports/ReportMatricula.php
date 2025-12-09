<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use PDF;

class ReportMatricula extends Controller {

    private $company;

    function __construct() {
        $this->middleware("auth");
    }

    public function primeira($id) {
        $matricula = Matricula::find($id);
        if ($matricula == null) {
            return redirect()->back()->with('info', 'Código da matrícula invávalido.');
        }
        $pdf = PDF::loadView("report.matricula.primeira", ["matricula" => $matricula]);
        #dd($pdf);
        return $pdf->download("FichaDeMatricula_{$id}.pdf");
    }

}
