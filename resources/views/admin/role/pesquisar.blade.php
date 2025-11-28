@extends("admin.role.indexRole")
@section("content-role")
<table id="example" class="table table-striped table-bordered table-sm table-responsive-sm">
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
        @forelse($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->label }}</td>
            <td>{{  \App\Base::strPart($role->description) }}</td>
            <td class="text-center">                                  
                <form  action="{{ route('role.destroy',$role->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <a href="{{ route("role.show", $role->id) }}"><i class="fa fa-eye text-info"> </i></a> &nbsp;
                    @if($role->id > 1)<a href="{{ route("role.edit", $role->id) }}"><i class="fa fa-edit text-success"> </i></a> &nbsp;
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>@endif
                </form>
            </td>
        </tr>                          
        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-center"> {{ $roles->appends(request()->input())->links() }} </td>
        </tr>
    </tfoot>
</table> 
@endsection