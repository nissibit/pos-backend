<div class="row">
    <div class="form-group col btn-group-sm">
        <a href="{{ route('company.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a> 
        <a href="{{ route('company.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-list"> listar</i>
        </a>
    </div>
    <div class="form-group col input-group-sm">
        <form id="company_pesquisar" role="form" autocomplete="off" action="{{ route('company.pesquisar') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ isset($dados['criterio']) ? $dados['criterio'] : old('criterio') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
