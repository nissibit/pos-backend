@extends('audit.indexAudit')
@section('content-audit')
<div class="card">
    <div class="card-header">
        <h2><strong> {{ $class.' : '.$name }} </strong></h2>
    </div>
    <div class="card-title">
        <div class="col"><strong>{{'Achados '.$audits->count() }}</strong></div>
    </div>
    <div class="card-body">

        <table id="example" class="table table-hover table-striped table-bordered table-sm table-responsive-sm">
            <thead>
                <tr>
                    <th>Acção</th>
                    <th>Utilizador</th>
                    <th>Entidade</th>
                    <th>Data & Hora</th>
                    <th>Valores Antigos</th>
                    <th>Novos Valores</th>
                </tr>
            </thead>
            <tbody id="audits">
                @forelse($audits as $audit)
                <tr>
                    <td>{{ $audit->event ?? 'N/A' }}</td>
                    <td>{{ $audit->user->name  ?? 'N/A' }}</td>
                    <td>{{ ($audit->auditable_type ?? 'N/A' ).": ".($audit->auditable->id  ?? 'N/A' )}}</td>
                    <td>{{ $audit->created_at  ?? 'N/A'  }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Sem registos
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection