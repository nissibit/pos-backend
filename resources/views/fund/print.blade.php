@extends("fund.indexFund")
@section("content-fund")
<div class="card">
   <div class="card-body">
        <iframe src="{{  route('report.fund', ['id' => $fund->id]) }}" width="100%" height="700px">
        </iframe>
    </div>
</div>
@endsection
