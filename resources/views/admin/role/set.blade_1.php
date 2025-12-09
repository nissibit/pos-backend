@extends("admin.role.indexRole")
@section("content-role")
<div class="col">
    <div class="card card">
        <div class="card-header">
            <i class="fa fa-user-shield"> Atribuindo perfil</i>            
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('role-set-store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-6 form-group input-group-sm">
                        <label for="user_id" class="control-label">{{ __('Utilizador') }} <b class="text-danger"> *</b></label>
                        <select id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror selectpicker" name="user_id" data-live-search="true" title="Seleccione utilizador">
                            <option value="">{{ __('----- Seleccione -----') }}</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-sm-6 btn-group-sm">
                        <label for="" class="control-label">&nbsp;</label><br />
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fa fa-plus-circle"> adicionar</i>
                        </button>
                    </div> 
                </div>    
                <div class="row">
                    <table class="table table-bordered table-hover table-striped table-sm table-responsive-sm">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onchange="selectAll(this.checked)" /></th>
                                <th>Perfil</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody class="@error('role_id') is-invalid @enderror">
                            @foreach($roles as $role)
                            <tr>
                                <td><input type="checkbox" name="role_id[]" id="{{ $role->id }}" value="{{ $role->id }}" /></td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                            </tr>
                            @endforeach
                            @error('role_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </tbody>
                    </table>
                </div>

            </form>   
        </div>                 

    </div>                       
</div>
@endsection
@section('post-script')
<script>
    function selectAll(obj) {
        var op = document.getElementsByName("role_id[]");
        for (i = 0; i < op.length; i++) {
            op[i].checked = obj;
        }
    }
    $(document).ready(function () {
        $('#exampleThis').DataTable({
            dom: 'frtp'
        });
    });
</script>
@endsection