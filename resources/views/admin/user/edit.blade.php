@extends("admin.user.indexUser")
@section("content-user")
<div class="card ">
    <div class="card-header">
        <i class="fa fa-user-edit"> Editar Utilizador</i>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('user.update',$user->id) }}">
            {{ method_field("PUT") }}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6 input-group-sm">
                    <label for="name">Name <span class="required  text-danger">*</span> </label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name ?? '') }}" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 input-group-sm">
                    <label for="username">User Name <span class="required  text-danger">*</span> </label>

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
                    <label for="email">E-Mail Address <span class="required  text-danger">*</span> </label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email ?? '') }}" >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 input-group-sm">
                    <label class="">Reiniciar Senha? <span class="required  text-danger">*</span> </label>
                    <div class="col">
                        <label class="control-label">
                            <input type="checkbox" name="resetpassword" id="resetpassword" value="{{ old('resetpassword') }}"  />
                        </label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col btn-group-sm text-right">
                    <button type="submit" class="btn btn-outline-success pull-right">
                        <i class="fa fa-edit"> alterar</i>
                    </button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection
