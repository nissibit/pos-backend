@extends("admin.import.indexImport")
@section("content-import")
<table  class="table table-striped table-bordered table-hover example" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>NUIT</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($companies as $import)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $import->name }}</td>
            <td>{{ $import->nuit }}</td>
            <td>{{ $import->tel }}</td>
            <td>{{ $import->email }}</td>
            <td>{{  \App\Base::strPart($import->description) }}</td>
            <td class="text-center">                                  
                <form  action="{{ route('import.destroy',$import->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <a href="{{ route("import.show", $import->id) }}"><i class="fa fa-eye text-info"> </i></a> &nbsp;
                    @if($import->id > 0)<a href="{{ route("import.edit", $import->id) }}"><i class="fa fa-edit text-success"> </i></a> &nbsp;
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>@endif
                </form>
            </td>
        </tr> 
        <?php $i++; ?>                            
        @endforeach
    </tbody>
</table> 
@endsection