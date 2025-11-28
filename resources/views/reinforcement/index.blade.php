@extends("reinforcement.indexReinforcement")
@section("content-reinforcement")

<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Data / Hora</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reinforcements as $reinforcement)
        <tr>
            <td><a href="{{ route('reinforcement.show', $reinforcement->id) }}"> {{ $reinforcement->id }} </a></td>
            <td class="text-right"><a href="{{ route('reinforcement.show', $reinforcement->id) }}"> {{ number_format($reinforcement->amount,2) }} </a></td>
            <td><a href="{{ route('reinforcement.show', $reinforcement->id) }}"> {{ $reinforcement->description }} </a></td>
            <td><a href="{{ route('reinforcement.show', $reinforcement->id) }}"> {{ $reinforcement->created_at->format('d-m-Y / h:i') }} </a></td>        
        </tr> 
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <thead>
         <tr>
            <td colspan="4" class="text-center">
               {{ $reinforcements->links() }}
            </td>
        </tr>
    </thead>
</table> 
@endsection