@extends("admin.role.indexRole")
@section("content-role")
<div class="col">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"> {{ __('Perfil dos utilizadores') }}</i>
        </div>   
        <div class="card-body">
            <div class="row">
                @can('show_set_role')
                <table class="table table-bordered table-hover table-striped table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Utilizador</th>
                            <th>Perfil(is)</th>
                            <th>{{ __('Remover') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                <a href="{{ route('role.show', $role->id) }}" data-type="checklist" data-value="{{$role->id}}" data-title="Select roles" data-name="role" class="role" data-pk="{{$role->id}}" role="button">
                                    <span class="badge badge-primary">{{$role->name}}</span>
                                </a>
                                @endforeach
                            </td>
                            <td class="text-left">
                                @can('delete_set_role')
                                <!--                                <a href="#" rel="popover" data-placement="left"  title="Eliminar perfil:"  data-popover-content="#{{ $user->id.'-'.$role->id }}" class="links">
                                                                    <i class="fa fa-trash text-danger"></i>                            
                                                                </a>-->
                                <div id="{{ $user->id.'-'.$role->id }}" class="form-group  btn-group-xs">
                                     @foreach($user->roles as $role)
                                     <form  action="{{ route('role-set-delete') }}" method="post">
                                        {{ csrf_field() }} 
                                        <div class="input-group-sm btn-group-xs">
                                        <input type="hidden" name="user_idd" value="{{ $user->id }}"/>
                                        <input type="hidden" name="role_idd" value="{{ $role->id }}"/>
                                          @if($user->id > 1)<button  type="submit" class="badge badge-danger">{{$role->name}}</button>@endif
                                        </div>
                                    </form>
                                    @endforeach                                            
                                </div>
                                @endcan
                            </td>
                            @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="3">
                                {{ $users->appends(request()->input())->links() }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection