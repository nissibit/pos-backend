@extends("admin.profissao.indexProfissao")
@section("content-profissao")
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
        @forelse($profissaos as $profissao)
        <tr>
            <td>{{ $profissao->id }}</td>
            <td>{{ $profissao->name }}</td>
            <td>{{ $profissao->alias }}</td>
            <td>{{  \App\Base::strPart($profissao->description) }}</td>
            <td class="text-center">                                  
                <form  action="{{ route('profissao.destroy',$profissao->id) }}" method="post">{{ csrf_field() }} {{ method_field('DELETE') }}
                    <a href="{{ route("profissao.show", $profissao->id) }}"><i class="fa fa-eye text-info"> </i></a> &nbsp;
                    <a href="{{ route("profissao.edit", $profissao->id) }}"><i class="fa fa-edit text-success"> </i></a> &nbsp;
                    <button  type="submit" data-toggle="confirmation" data-title="Suprimir Profissão ?" class="btn btn-link"><i class="fa fa-trash text-danger"> </i></button>
                </form>
            </td>
        </tr>                          
        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
</table> 
@endsection