<div class="row">
    <div class="col btn-group-sm">
        @can('create_permission')
        <a href="{{ route('permission.create') }}" class="btn btn-outline-primary">
            <i class="fa fa-plus-circle"> criar</i>
        </a>       
        @endcan
    </div>  
    <div class="col btn-group-sm">
        @can('create_set_permission')
        <a href="{{ route('permission-set') }}" class="btn btn-outline-secondary">
            <i class="fa fa-check-square"> atribuir permisão</i>
        </a>       
        @endcan
    </div>  
    <div class="form-group col">
        @can("pesquisa_role")
        <form id="role_pesquisar" role="form" autocomplete="off" action="{{ route('permission.pesquisar') }}" method="get">
            <div class="input-group input-group-sm">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', request()->input()['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa fa-cogs"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
        @endcan       
    </div> 
</div> 