@extends("admin.company.indexCompany")
@section("content-company")
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
        @foreach($companies as $company)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->nuit }}</td>
            <td>{{ $company->tel }}</td>
            <td>{{ $company->email }}</td>
            <td>{{  \App\Base::strPart($company->description) }}</td>
            <td class="text-center">                                  
                <form  action="{{ route('company.destroy',$company->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <a href="{{ route("company.show", $company->id) }}"><i class="fa fa-eye text-info"> </i></a> &nbsp;
                    @if($company->id > 0)<a href="{{ route("company.edit", $company->id) }}"><i class="fa fa-edit text-success"> </i></a> &nbsp;
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Perfil?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>@endif
                </form>
            </td>
        </tr> 
        <?php $i++; ?>                            
        @endforeach
    </tbody>
</table> 
@endsection