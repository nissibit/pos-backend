@extends("admin.permission.indexPermission")
@section("content-permission")
<div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"> Ver dados</i>
            </div>   
            <div class="card-body">
                @if(session("infoo"))
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i class="fa fa-info-circle"> {{ session("infoo") }}</i>
                </div>
                @endif
                @if(session("sucessoo"))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i class="fa fa-check-circle"> {{ session("sucessoo") }}</i>
                </div>
                @endif
                @if(session("falhaa"))
                <div class="alert  alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i class="fa fa-times-circle"> {{ session("falhaa") }}</i>
                </div>
                @endif
                <div class="responsive">
                    @can('show_set_permission')
                    <table id="exampleThis" class="table table-bordered table-responsive table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Utilizador</th>
                                <th>Permissões</th>
                                <th>Operação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a data-toggle="collapse"href="{{ '#rp'.$role->id  }}"> <i class="fa fa-list"></i></a>&nbsp
                                    <div id="{{ 'rp'.$role->id }}" class="collapse">          
                                        <ul style="list-style: none"> 
                                            @foreach($role->permissions as $permission) 
                                            <li>{{ $permission->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @can('delete_set_permission')
                                    <a href="#"  data-toggle="confirmation" rel="popover" data-placement="left"  title="Eliminar perfil:"  data-popover-content="#{{ $role->id.'-'.$permission->id }}" class="links">
                                        <i class="fa fa-trash text-danger"></i>                            
                                    </a>
                                    <div id="{{ $role->id.'-'.$permission->id }}" class="hide">
                                        @foreach($role->permissions as $permission)
                                        <form  action="{{ route('permission-set-delete') }}" method="post">
                                            {{ csrf_field() }} 
                                            <input type="hidden" name="role_idd" value="{{ $role->id }}"/>
                                            <input type="hidden" name="permission_idd" value="{{ $permission->id }}"/>
                                            <button  type="submit" class="btn btn-link">{{$permission->name}}</button>
                                        </form>
                                        @endforeach                                            
                                    </div>
                                    @endcan
                                </td>

                                @endforeach
                        </tbody>
                    </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

