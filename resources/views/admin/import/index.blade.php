@extends("admin.import.indexImport")
@section("content-import")
<div class="card">
    <div class="card-header">
        <i class="fa fa-upload"> {{ __('Escolher o tipo de dados') }} <strong>{{ $model ?? ''}}</strong></i>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="get" action="{{ route('import.create') }}">
           <div class="row">
                <div class="col form-group input-group-sm">
                    <label for="model" class="control-label">Tipo <b class="text-danger">*</b></label>
                    <select id="model" class="form-control selectpicker @error('model') is-invalid @enderror" name="model">
                        <option value=""> ----- Seleccione ----- </option>
                        @foreach(\App\Base::models() ?? array() as $key => $model)
                        <option value="{{ $key }}"> {{ __('messages.entity.'.strtolower($model)) }}</option>
                        @endforeach
                    </select>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row text-right">
                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-primary pull-right">
                         {{ __('proximo') }} <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection