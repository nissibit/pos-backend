@extends("quotation.indexQuotation")
@section("content-quotation")
@php
$enableSend = true
@endphp
<div class="card">
    <div class="row">
        <div class="col">  
            <a href="{{ route('report.quotation', $quotation->id) }}" class="btn btn-danger form-control">
                <i class="fas fa-print"> Modelo -A4 </i>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('report.quotation.modelo2', $quotation->id) }}" class="btn btn-danger form-control">
                <i class="fas fa-print"> Modelo - A5 </i>
            </a>
        </div>
        
        <div class="col">       
            <a href="{{ route('quotation.copy', ['id' => $quotation->id]) }}" class="btn btn-primary form-control">
                <i class="fas fa-copy"> Copiar </i>
            </a>
        </div>
        <div class="col">
            @can('audit_quotation')
            <form role='form' action="{{ route('audit.entity') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $quotation->id }}"  />
                <input type="hidden" name="model" value="\App\Models\Quotation"  />
                <input type="hidden" name="name" value="{{ $quotation->created_at->format('d-m-Y h:i') }}"  />
                <button type="submit" class="btn btn-primary form-control">            
                    <i class="fa fa-user-shield"> auditar</i>
                </button>
            </form>
            @endcan
        </div>
   </div>

    <div class="card-body">
        <iframe src="{{  route('report.quotation.modelo2', ['id' => $quotation->id]) }}" width="100%" height="700px">
        </iframe>
    </div>
</div>
@endsection
