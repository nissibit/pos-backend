<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Devolution;
use App\Models\Company;

class DevolutionReport extends Controller {

    protected $devolution;

    function __construct(Devolution $devolution, Company $company) {
        $this->devolution = $devolution;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function devolution(Request $request) {
        $height = "100%";
        $devolution = $this->devolution->find($request->id);    
        
        $company = $this->company->first();
        $pdf = PDF::loadView("report.devolution.one", compact('devolution', 'company', 'height'))->setPaper('A5', 'landscape');
        return $pdf->stream("Devolução_{$devolution->id}.pdf", ['Attachment' => true]);
    }

}
