@extends("fund.indexFund")
@section("content-fund")
<?php $meios = \App\Base::meioPagamento(); ?>
<div class="card">
    <div class="card-header">
        <h2><i class="fa fa-close"> Fechar Fundo: <strong class="text-danger">{{ number_format($fund->present, 2) }}</strong> </i></h2>
    </div>
    <div class="card-header">
            <a href="{{ route('report.fund.moneyflow', ['id' => $fund->id]) }}" class="btn btn-danger">
                    <i class="fa fa-print"> Fundo</i>
            </a>    
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle fa-2x">Verifique os dados antes de terminar esta operação porque não poderá ser alterada nem removida.</i>
        </div>
        <form role="form" autocomplete="off" class="form-horizontal" action="{{ route('fund.update', $fund->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group col-sm-6 input-group-sm d-none">
                <label class="control-label">
                    Valor Actual <i class="text-danger">*</i>
                </label>
                <input type="text" class="form-control @error('present') is-invalid @enderror" name="present" id="present" value="{{ old('present', $fund->present ?? '') }}" readonly="readonly"  />
                @error('present')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="row ">
                <?php $i = 1; $idmeios = array(); ?>
                @foreach(\App\Base::meioPagamento() ?? array() as $key => $value)
                @php
                $meio = preg_replace('/\s+/', '_', $value);
                $idmeios[] = $meio;
                @endphp
                
                <div class="form-group col-sm-6 input-group-sm {{ $meio != "Cash" ? 'd-none' : '' }}">
                    <label class="control-label">
                        {{ $value }} <i class="text-danger">*</i>
                    </label>
                    <input type="text" class="form-control dinheiro @error('{{ $meio }}') is-invalid @enderror" name="" id="" value="{{ number_format(old($meio, 0), 2) }}" onkeyup="$('{{ "#". $meio }}').val(replaceMoeda(this.value)); calcula();" />
                    <input type="hidden" class="form-control @error('{{ $meio }}') is-invalid @enderror" name="{{ $meio }}" id="{{ $meio }}" value="{{ old($meio, 0) }}" onkeyup="calcula();" />
                    @error('{{ $meio }}')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @if($i % 2 == 0)
            </div>
            <div class="row">
                @endif          
                @endforeach
                <div class="form-group col-sm-6 input-group-sm">
                    <label class="control-label">
                        Valor Total <i class="text-danger">*</i>
                    </label>
                    <input type="text" class="form-control @error('informed') is-invalid @enderror" name="informed" id="informed" value="{{ old('informed', $fund->informed ?? '') }}" readonly="READONLY"  />
                    @error('informed')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm-6 input-group-sm">
                    <label class="control-label">
                        Diferença <i class="text-danger">*</i>
                    </label>
                    <input type="text" class="form-control @error('missing') is-invalid @enderror" name="missing" id="missing" value="{{ old('missing', $fund->missing ?? '') }}" readonly="readonly" />
                    @error('missing')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm-6 input-group-sm">
                    <label class="control-label">
                        Justificativa
                    </label>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description', $fund->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success" >
                        <i class="fa fa-close"> fechar</i>
                    </button>
                </div>

        </form>
    </div>
</div>
    <script type="text/javascript">
    var meios = <?php echo json_encode($idmeios) ?>;
    document.addEventListener('DOMContentLoaded', function(){ 
    $("#informed").focus();
    });
    function calcula() {
    var somar = 0;
    var aux = "";
    var me = "";
    for (var i = 0; i < meios.length; i++) {
    aux = document.getElementById(meios[i]).value;
    somar += (aux !== "" && aux !== undefined) ? parseFloat(aux) : 0;
    }
    $('#informed').val(somar);
    var informed = somar;
    var present = parseFloat($('#present').val());
    var missing = parseFloat($('#missing').val());
    missing = informed - present;
    $('#missing').val(missing);
    };
</script>
@endsection