@extends("payment.cashier.indexCashier")
@section("content-cashier")
<div class="card">
    <div class="card-header">
        <h2><i class="fa fa-folder-open"> @lang('messages.payment.cashier_open')</i></h2>        
    </div>
    <div class="card-body">
        <form role="form" autocomplete="off" class="form-horizontal" action="{{ route('cashier.store') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group col input-group-sm">
                    <label class="control-label">
                        @lang('messages.cashier.initial') (MT) <i class="text-danger">*</i>
                    </label>
                    <input type="text" class="form-control @error('initial') is-invalid @enderror" name="initial" id="initial" value="{{ old('initial', $cashier->initial ?? '0') }}"  />
                    <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id" value="{{ old('user_id', auth()->user()->id ) }}"  />
                    <input type="hidden" class="form-control @error('startime') is-invalid @enderror" name="startime" id="startime" value="{{ old('startime', \Carbon\Carbon::now()->format('Y-m-d h:m:i'))  }}"  />
                    @error('initial')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col btn-group-sm text-right">
                    <button type="submit" class="btn btn-outline-primary" >
                        <i class="fa fa-check-circle"> criar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection