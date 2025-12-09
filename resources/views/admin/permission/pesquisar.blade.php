@extends("admin.permission.indexPermission")
@section("content-permission")
<table class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>Sigla</th>
            <th>Descrição</th>
            <th>Operações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($permissions as $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->label }}</td>
            <td>{{  \App\Base::strPart($permission->description) }}</td>
            <td class="text-center">                                  
                <form  action="{{ route('permission.destroy',$permission->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <a href="{{ route("permission.show", $permission->id) }}"><i class="fa fa-eye text-info"> </i></a> &nbsp;
                    <!-- <a href="{{ route("permission.edit", $permission->id) }}"><i class="fa fa-edit text-success"> </i></a> &nbsp;
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button> -->
                </form>
            </td>
        </tr>      
        @empty
        <tr>
            <td class="text-center" colspan="5"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="5"> 
                {{ $permissions->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>  
@endsection