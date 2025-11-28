<div class="row">
    <div class="form-group col btn-group-sm">
        @can("create_user")
        <a href="{{ route('user.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a>
        @endcan
        @can("show_user")
        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> listar</i>
        </a>
        @endcan 
        @can("listset_role")
        <a href="{{ route('role.listset') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> perfil</i>
        </a>
        @endcan         
    </div>    
    <div class="form-group col">
        @can("pesquisa_user")
        <form id="user_pesquisar" role="form" autocomplete="off" action="{{ route('user.pesquisar') }}" method="get">
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