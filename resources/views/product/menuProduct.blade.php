<div class="row">
    <div class="form-group col btn-group-sm">
        @can('create_product')   
        <a href="{{ route('product.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus-circle"> criar</i>
        </a> 
        @endcan  
        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary ml">
            <i class="fas fa-list"> listar</i>
        </a>
        @can('create_stock')
        <a href="{{ route('stock.create') }}" class="btn btn-outline-secondary ml">
            <i class="fas fa-plus-circle"> stock</i>
        </a>
        @endcan
    </div>
    <div class="form-group col input-group-sm">
        <form id="category_search" role="form" autocomplete="off" action="{{ route('product.by_category') }}" class="m-sm-1" method='get'>
            <div class="input-group-sm input-group">
                <select class="form-control" name="category_id">
                    <option value=""> ----- Selecciona Categoria----- </option>
                    @foreach(\App\Models\Category::all()->sortBy('name') ?? array() as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $dados['category_id'] ?? '') == $category->id ? 'selected' : '' }}>  {{ $category->name }}</option>                    
                    @endforeach
                </select>
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>        
    </div>    
    <div class="form-group col input-group-sm">
        <form id="unity_search" role="form" autocomplete="off" action="{{ route('product.by_unity') }}" class="m-sm-1" method='get'>
            <div class="input-group-sm input-group">
                <select class="form-control" name="unity_id">
                    <option value=""> ----- Selecciona Unidade----- </option>
                    @foreach(\App\Models\Unity::all()->sortBy('name') ?? array() as $unity)
                    <option value="{{ $unity->id }}" {{ old('unity_id', $dados['unity_id'] ?? '') == $unity->id ? 'selected' : '' }}>  {{ $unity->name }}</option>                    
                    @endforeach
                </select>
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>
    <div class="form-group col input-group-sm">
        <form id="unity_search" role="form" autocomplete="off" action="{{ route('product.search') }}" method="get" class="m-sm-1">            
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div> 
