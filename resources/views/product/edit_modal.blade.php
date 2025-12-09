<div class="modal-header">
    <div class="card card-header ">
        <i class="fa fa-user fa-edit"> Editar Produto {{ $product->name ?? "N/A" }}</i>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="form-horizontal" method="POST" action="">
    <div class="modal-body" >
        <div class="row" id="msgEditProduct"></div>
        @include('menu.alert')
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-sm-6 form-group input-group-sm">              
                <label for="barcode" class="control-label">Codigo de barras <i class="fa fa-barcode"></i> </label>
                <input id="barcode" type="text" class="form-control" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}"  >
                <input id="id" type="hidden" class="form-control" name="id" value="{{ old('id', $product->id ?? '') }}"  >

            </div>
            <div class="col-sm-6 form-group input-group-sm">
                <label for="othercode" class="control-label">Outro codigo</label>
                <input id="othercode" type="text" class="form-control" name="othercode" value="{{ old('othercode', $product->othercode ?? '') }}"  >

            </div>
        </div>            
        <div class="row">
            <div class="col-sm-6 form-group input-group-sm">
                <label for="name" class="control-label">Nome/Designação <b class="text-danger">*</b></label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}"  >

            </div>
            <div class="col-sm-6 form-group input-group-sm">
                <label for="label" class="control-label">Abreviatura <b class="text-danger">*</b></label>
                <input id="label" type="text" class="form-control" name="label" value="{{ old('label', $product->label ?? '') }}"  >
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group input-group-sm">
                <label for="description" class="control-label">Descrição</label>
                <textarea id="description"  type="description"  name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="callRetalho()">Fechar</button>
        <button type="button" onclick="editProduct();" class="btn btn-success pull-right">
            <i class="fa fa-check-circle"> editar</i>
        </button>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $('#name').on('keyup', function (key) {
            $('#label').val(this.value.replace(/ /g, '_').toLowerCase());
        });
    });
    function editProduct() {
        var url = '{{ route("api.product.update.modal") }}';
        var id = $('#id').val();
        var barcode = $('#barcode').val();
        var othercode = $('#othercode').val();
        var name = $('#name').val();
        var label = $('#label').val();
        var description = $('#description').val();

        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, barcode: barcode, othercode: othercode, name: name, label: label, description: description},
            success: function (data) {
                $('#msgEditProduct').html(data);
                callRetalho();
            }
        });
    }
</script>