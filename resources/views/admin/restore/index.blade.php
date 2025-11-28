@extends("admin.restore.indexRestore")
@section("content-restore")
<table id="example" class="table table-striped table-bordered table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>Entidade</th>
            <th>Acção</th>
            <th>Utilizador</th>
            <th>Data & Hora</th>
            <th>Valores</th>
            <th>Operações</th>
        </tr>
    </thead>
    <tbody id="audits">
        @forelse($audits as $audit)
        <tr>
            <td>{{ $audit->tags ?? '' }}</td>
            <td>{{ $audit->event ?? '' }}</td>
            <td>{{ $audit->user->name ?? '' }}</td>
            <td>{{ $audit->created_at ?? ''}}</td>
            <td>
                <a data-toggle="collapse"href="{{ '#audit-old'.$audit->id  }}">  antigos... </a>&nbsp
                <div id="{{ 'audit-old'.$audit->id }}" class="collapse">
                    <ul>
                        @foreach($audit->old_values as $attribute => $value)
                        <li><b>{{ $attribute.' : '}}</b> {{ $value }}</li>                     
                        @endforeach
                    </ul>
                </div>
            </td>
            
            <td class="btn-group-sm">
                <a href="{{ route('restore.show', $audit->id) }}" class=" btn btn-primary">
                    <i class="fa fa-cogs"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Sem registos
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection


