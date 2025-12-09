<div class="row">
    <div class="form-group col btn-group-sm">   
      
        <a href="{{ route('creditnote.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-list"> listar</i>
        </a>
    </div>

    <div class="form-group col input-group-sm">
        <form id="creditnote_search" role="form" autocomplete="off" action="{{ route('creditnote.search') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
