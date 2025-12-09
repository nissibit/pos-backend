<div class="row">
    <div class="form-group col btn-group-sm">
        @can("create_profissao")
        <a href="{{ route('profissao.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a>
        @endcan
        @can("show_profissao")
        <a href="{{ route('profissao.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"> listar</i>
        </a>
        @endcan         
    </div>    
    <div class="form-group col">
        @can("pesquisa_profissao")
        <form id="profissao_pesquisar" profissão ="form" autocomplete="off" action="{{ route('profissao.pesquisar') }}" method="get">
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