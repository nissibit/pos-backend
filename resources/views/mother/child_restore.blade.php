@extends('mother.indexMother')
@section('content-product')
<div class="card">
    <div class="card-header">
        <i class="fas fa-asterisk"></i> Restauração do produto retalho <strong>{{ $productChild->productByChild->name }}</strong>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('mother.child.restore') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col form-group input-group-sm">
                    <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $productChild->id }}" />

                    <strong><label for="quantity" class="control-label">Quantidade de redução <b class="text-danger">*</b></label></strong>
                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $data['quantity'] ?? '' }}"  >
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col btn-group-sm ">
                    <a href="{{ route('product.show', $productChild->parent) }}" class="btn btn-outline-secondary pull-right">
                        <i class="fa fa-times-circle"> NÃO</i>
                    </a>
                </div>
                <div class="col btn-group-sm text-right">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-check-circle"> SIM</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
