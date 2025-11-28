@extends("admin.user.indexUser")
@section("content-user")
<div class="col">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-lock"> </i> {{ __('Change password to'). ' '}} <strong> {{ $user->name ?? '' }} </strong>
        </div>
        <div class="card-body">
            <form role="form" class="form-horizontal" method="post" action="{{ route('user.changepwd') }}">
                {{ @csrf_field() }}
                <div class="form-group input-group-sm">
                    <label class="form-label-left"> Senha Actual *</label>
                    <input type="password" name="oldpass" class="form-control @error('oldpass') is-invalid @enderror" value="{{ old('oldpass') }}" />
                     @error('oldpass')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group input-group-sm">
                    <label class="form-label-left"> Nova Senha *</label>
                    <input type="password" name="newpass" class="form-control @error('newpass') is-invalid @enderror" value="{{ old('newpass') }}" />
                     @error('newpass')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group input-group-sm">
                    <label class="form-label-left"> Confirmação *</label>
                    <input type="password" name="confpass" class="form-control @error('confpass') is-invalid @enderror" value="{{ old('confpass') }}" />
                     @error('confpass')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group btn-group-sm text-right">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-edit"> editar</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection