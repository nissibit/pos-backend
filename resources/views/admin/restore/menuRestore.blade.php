<div class="row">
    <div class="form-group col-sm-4 btn-group-sm">
        @can("show_audit")
        <a href="{{ route('restore.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> listar</i>
        </a>
        @endcan         
    </div>    
    <div class="form-group col">
        @can("pesquisa_audit")
        <form id="audit_pesquisar" profissão ="form" autocomplete="off" action="{{ route('restore.search') }}" method="get">
            <div class="input-group input-group-sm">
                <div class="row">
                    <div class="col form-group input-group-sm">
                        <select id="model" class="form-control selectpicker @error('model') is-invalid @enderror" name="model">
                            <option value="All"> ----- Seleccione Entidade ----- </option>
                            @foreach(\App\Base::models() ?? array() as $key => $model)
                            <option value="{{ $key }}" {{ old('model', $dados["model"] ?? '')== $key ? 'selected': '' }} > {{ __('messages.entity.'.strtolower($model)) }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa"  value="{{ old('criterio', request()->input()['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
        @endcan       
    </div> 
</div> 