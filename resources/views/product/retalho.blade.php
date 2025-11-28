<div class="card">
    <?php
    $children = $product->children()->latest()->paginate(10);
    ?>
    <div class="card-body">
        <div class="card-header">
            <form class="form-horizontal" method="POST" action="{{ route('product.child.save') }}">
                {{ csrf_field() }}
                <div class="row">
                    <input type="hidden" class="form-control" name="parent" id="parent" value="{{ $product->id ?? '' }}"   /> 
                    <input type="hidden" class="form-control" name="child" id="child" value="{{ old('child', $parent->child ?? '') }}"   />                
                    <div class="form-group input-group-sm col-sm ui-widget">
                        <label for="name">Procurar <i class="fa fa-search"></i> </label>
                        <input type="text" class="form-control" name="search" id="search" value="{{ old('search', $parent->name ?? '') }}"   />                
                    </div>

                    <div class="form-group input-group-sm col-sm">
                        <label for="name">Produto </label>
                        <input type="text" class="form-control @error('child') is-invalid @enderror" name="name" id="name" value="{{ old('name', $parent->name ?? '') }}"  readonly="readonly" />                            
                        @error('child')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group input-group-sm col-sm">
                        <label for="stock"><i class="fa fa-stock"></i> Stock</label>
                        <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock', $parent->stock ?? '') }}" readonly="readonly" />                
                        
                    </div>
                    <div class="form-group input-group-sm col-sm">
                        <label for="stock"><i class="fa fa-stock"></i> Qtd. A reduzir</label>
                        <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity" value="{{ old('quantity', $parent->quantity ?? '') }}"  />                
                        @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group input-group-sm col-sm">
                        <label for="total">&nbsp; </label>
                        <button type="submit" class="btn btn-primary pull-right form-control">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>Cod. Barras.</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Redução</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($children as $parent)
                @php
                $child = \App\Models\Product::find($parent->child);
                @endphp
                @if($child != null)
                <tr>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->barcode }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->name ?? 'N/A' }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ number_format($child->price ?? 0, 2) }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->category->name ?? 'N/A' }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ number_format($parent->quantity ?? 0, 3) }}</a></td>
                    <td class="btn-group-sm">
                        <a href="{{ route('product.child.destroy', $parent->id) }}" class="btn btn-outline-danger ml">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="5" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>   
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center">  {{ $children->appends(request()->input())->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                getProduct(ui.item.id, 'id');
                $('#search').val('');
                $('#search').focus();
                return false;
            }
        });
        function getProduct(id, searchBy) {
            var url = '{{ route("api.get.product") }}';
            $.ajax({
                'type': 'GET',
                'url': url,
                data: {id: id, searchBy},
                success: function (data) {
                    product = JSON.parse(data);
                    if (product !== null) {
                        $('#child').val(product.id);
                        $('#name').val(product.name);
                        $('#stock').val(product.description);
                    } else {
                        $('#name').val('');
                    }

                }
            });
        }
    });
</script>