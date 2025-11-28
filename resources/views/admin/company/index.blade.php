@extends("admin.company.indexCompany")
@section("content-company")
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
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
        @forelse($companies as $company)
        <tr>
            <td>{{ $company->id }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->nuit }}</td>
            <td>{{ $company->tel }}</td>
            <td>{{ $company->email }}</td>
            <td>{{  \App\Base::strPart($company->description) }}</td>
            
        </tr> 
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
</table> 
@endsection