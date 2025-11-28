@extends("admin.user.indexUser")
@section("content-user")
<div class="card">
    <div class="card-header">
        <i class="fa fa-user-plus"> Registar Utilizador</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('user.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 input-group-sm">
                    <label for="name">Nome <span class="required  text-danger">*</span> </label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name ?? '') }}" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 input-group-sm">
                    <label for="username">Utilizador <span class="required  text-danger">*</span> </label>

                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username ?? '') }}" autofocus>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 input-group-sm">
                    <label for="email">Email <span class="required  text-danger">*</span> </label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email ?? '') }}" >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 input-group-sm">
                    <label for="password">Password <span class="required  text-danger">*</span> </label>                    
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  value="{{ old('password', $user->password ?? '') }}"  readonly='readonly'  >
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 input-group-sm">
                    <label for="password-confirm">Confirm Password <span class="required  text-danger">*</span> </label>
                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password', $user->password ?? '') }}" readonly='readonly'>
                    @error('password-confirm')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col btn-group-sm text-right">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-save"> guardar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $('#username').on('keyup', function (obj) {
            var senha = this.value;
            $('#password').val(senha);
            $('#password-confirm').val(senha);
        })
    });
</script>
@endsection
