@extends("admin.restore.indexRestore")
@section("content-restore")
<table id="example" class="table table-striped table-bordered table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>Model</th>
            <th>Acção</th>
            <th>Utilizador</th>
            <th>Data & Hora</th>
            <th>Valores Antigos</th>
            <th>Novos Valores</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="audits">
        @forelse($audits as $audit)
        <tr>
            <td>{{ $audit->tags ?? ''}}</td>
            <td>{{ $audit->event ?? '' }}</td>
            <td>{{ $audit->user->name ?? '' }}</td>
            <td>{{ $audit->created_at ?? '' }}</td>
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
            <td>
                <a data-toggle="collapse"href="{{ '#audit-new'.$audit->id  }}">  novos... </a>&nbsp
                <div id="{{ 'audit-new'.$audit->id }}" class="collapse">
                    <ul>
                        @foreach($audit->new_values as $attribute => $value)
                        <li><b>{{ $attribute.' : '}}</b> {{ $value }}</li>   
                        @endforeach
                    </ul>
                </div>
            </td>
            <td class="text-center">
                <a href="{{ route('restore.show', $audit->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center">
                {{ $audits->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection