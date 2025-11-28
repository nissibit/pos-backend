@extends("admin.permission.indexPermission")
@section("content-permission")
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-lock"> Atribuindo permissões</i>
            </div>
            <div class="card-body">
                @include('menu.alert')
                <form class="form-horizontal" method="POST" action="{{ route('permission-set-store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col input-group-sm">
                            <label for="role_id" class="control-label">Perfil <b class="text-danger"> *</b></label>
                            <select id="role_id" type="text" class="form-control selectpicker" name="role_id"  required data-live-search="true" title="Seleccione utilizador">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}> {{ $role->id.'-'.$role->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                            @endif
                        </div> 
                        <div class="col btn-group-sm">
                            <label for="" class="control-label">&nbsp;</label><br />
                            <button type="submit" class="btn btn-outline-success">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div> 
                    </div>    
                    <div class="row">
                        <div class="col">
                            <table  class="table table-bordered table-sm table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="selectAll(this.checked)" /></th>
                                        <th>Permissão</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                    <tr>
                                        <td><input type="checkbox" name="permission_id[]" id="{{ $permission->id }}" value="{{ $permission->id }}" /></td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->description }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Sem registos ...
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            {{ $permissions->appends(request()->input())->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </form>   
            </div>                 

        </div>
    </div>   
</div>
<script>
    function selectAll(obj) {
        var op = document.getElementsByName("permission_id[]");
        for (i = 0; i < op.length; i++) {
            op[i].checked = obj;
        }
    }
    $(document).ready(function () {
        $('#exampleThis, #examplePermission').DataTable();
    });
</script>
@endsection