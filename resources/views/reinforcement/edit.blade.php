@extends('reinforcement.indexReinforcement')
@section('content-reinforcement')
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit"> Editar Reinforcement <b>{{$reinforcement->name }}</b></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('reinforcement.update', $reinforcement->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row input-group-sm">
                @if($fund ?? null != null)
                <label for="name" class="control-label">Produto <b class="text-danger">*</b></label>
                <input type="text" class="form-control" name="fund_name" id="fund_name" value="{{ old('fund_name', $reinforcement->fund->name ?? '') }}"  readonly="readonly" />   
                @else

                <div class="form-group col-sm">
                    <label for="name" class="control-label">Seleccionar Produto <b class="text-danger">*</b></label>
                    <select class="form-control @error('fund_combo') is-invalid @enderror" id="fund_combo" name="fund_combo">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach(\App\Models\Fund::all()->sortBy('name') ?? array() as $fund)
                        <option value="{{ $fund->id }}" {{ old('fund_id', $dados['fund_id'] ?? '') == $fund->id ? 'selected' : '' }}>  {{ $fund->name }}</option>                    
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm">
                    <label for="barcode"><i class="fa fa-barcode"></i> Cod. barras</label>
                    <input type="text" class="form-control" name="barcode" id="barcode" value="{{ old('barcode', $reinforcement->barcode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="othercode">Outro Codigo </label>
                    <input type="text" class="form-control" name="othercode" id="othercode" value="{{ old('othercode', $reinforcement->othercode ?? '') }}" />                
                </div>
                <div class="form-group col-sm">
                    <label for="name">Produto </label>
                    <input type="text" class="form-control @error('fund_id') is-invalid @enderror" name="name" id="name" value="{{ old('name', $reinforcement->name ?? '') }}"  readonly="readonly" />                
                    @error('fund_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                @endif
                <input type="hidden" class="form-control" name="fund_id" id="fund_id" value="{{ old('fund_id', $reinforcement->fund_id ?? '') }}"  readonly="readonly" />                
            </div>
            <div class="row">
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Armazem/Loja <b class="text-danger">*</b></label>
                    <select class="form-control @error('store_id') is-invalid @enderror" name="store_id">
                        <option value=""> ----- Selecciona ----- </option>
                        @foreach($stores ?? array() as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $reinforcement->store_id ?? '') == $store->id ? 'selected' : '' }}>  {{ $store->name }}</option>                    
                        @endforeach
                    </select>
                    @error('store_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>      
                <div class="col-sm-6 form-group input-group-sm">
                    <label for="label" class="control-label">Quatidade <b class="text-danger">*</b></label>
                    <input id="quantity" type="quantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $reinforcement->quantity ?? '') }}"  >
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-edit"> editar</i>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<script type="text/javascript">
    $("#fund_combo").on('change', function () {
        $('barcode').val('');
        $('othercode').val('');
        $('#name').val(this.selectedIndex.text);
        $('#fund_id').val(this.value);
    });
    $("#barcode").on('keyup', function () {
        var id = this.value;
        $('#othercode').val('');
        document.getElementById("fund_combo").selectedIndex = 0;
        getFund(id, 'barcode');
    });

    $("#othercode").on('keyup', function () {
        var id = this.value;
        $('#barcode').val('');
        document.getElementById("fund_combo").selectedIndex = 0;
        getFund(id, 'othercode');
    });
    function getFund(id, searchBy) {
        var url = '{{ route("api.get.fund") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, searchBy},
            success: function (data) {
                fund = JSON.parse(data);
                if (fund !== null) {
                    $('#name').val(fund.name);
                    $("#fund_id").val(fund.id);
                } else {
                    $('#name').val('');
                    $('#fund_id').val('');
                }

            }
        });
    }

</script>
@endsection