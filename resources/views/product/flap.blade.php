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
                        <input type="text" class="form-control @error('child') is-invalid @enderror" name="name" id="nome" value="{{ old('name', $parent->name ?? '') }}"  readonly="readonly" />                            
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
        <div id="flap_table">
            @include("product.flap_table")
        </div>
    </div>
</div>
<!--Modal para editar-->
<div class="modal fade" id="exampleModalLive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="contentModal">
            
        </div>
    </div>
</div>
<!-- FIM Modal para editar-->
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
                        $('#nome').val(product.name);
                        $('#stock').val(product.description);
                    } else {
                        $('#name').val('');
                    }

                }
            });
        }
    });
    function callModalEdit(id) {
        var url = '{{ route("api.product.edit.modal") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id},
            success: function (data) {
                $("#contentModal").html(data);
                $("#exampleModalLive").modal({
                    "keyboard":false,
                    "backdrop": false
                });
            }
        });
    }
    function callModalPrice(id) {
        var url = '{{ route("api.product.price.edit.modal") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id},
            success: function (data) {
                $("#contentModal").html(data);
                $("#exampleModalLive").modal({
                    "keyboard":false,
                    "backdrop": false
                });
            }
        });
    }
    function callRetalho() {
        var id = '{{ $product->id }}';
        var url = '{{ route("api.product.get-flap") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id},
            success: function (data) {
                $("#flap_table").html(data);
            }
        });
    }
</script>