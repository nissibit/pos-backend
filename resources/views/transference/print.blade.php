@extends('transference.indexTransference')
@section('content-transference')
<div class="card">
   <div class="card-body">
        <iframe src="{{  route('report.transference', ['id' => $transference->id]) }}" width="100%" height="700px">
        </iframe>
    </div>
</div>
@endsection
