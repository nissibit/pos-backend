@extends("price.indexPrice")
@section("content-price")
<div class="card">
    <div class="row m-2">
        <div class="col">
            <a href="{{ route('report.price.modelo_1', $price->id) }}" class="btn btn-danger form-control">
                <i class="fas fa-print"> Modelo -A4 </i>
            </a>
        </div>
        &nbsp;
        <div class="col">
            <a href="{{ route('report.price.modelo_2', $price->id) }}" class="btn btn-danger form-control">
                <i class="fas fa-print"> Modelo - A5</i>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('price.copy', ['id' => $price->id]) }}" class="btn btn-primary form-control">
                <i class="fas fa-copy"> </i>
            </a>
        </div>

        <div class="col">
            @can('audit_price')
            <form role='form' action="{{ route('audit.entity') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $price->id }}"  />
                <input type="hidden" name="model" value="\App\Models\Price"  />
                <input type="hidden" name="name" value="{{ $price->created_at->format('d-m-Y h:i') }}"  />
                <button type="submit" class="btn btn-primary form-control">            
                    <i class="fa fa-user-shield"> auditar</i>
                </button>
            </form>
        </div>
        <div class="col">
            @endcan
            <form  action="{{ route('price.destroy',$price->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                @can('price_destroy')<button type="submit" data-toggle="confirmation" data-title="Suprimir?" class="btn btn-danger form-control"><i class="fa fa-trash"> </i></button>@endcan
            </form>
        </div>
    </div>
    <div class="card-body">
        <iframe src="{{  route('report.price.modelo_1', ['id' => $price->id]) }}" width="100%" height="700px">
        </iframe>
    </div>
</div>
@endsection
