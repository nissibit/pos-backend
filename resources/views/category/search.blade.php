@extends("category.indexCategory")
@section("content-category")
<div class="text-right">
    <a href="{{ route('report.category.all') }}" class="btn btn-secondary">
        <i class="fa fa-print"></i>
    </a>
</div>
<br />
<table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Designação</th>
            <th>Abreviatura</th>
            <th>Descrição</th>
            <th>Produtos(#)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><a href="{{ route('category.show', $category->id) }}"> {{ $category->id }} </a></td>
            <td><a href="{{ route('category.show', $category->id) }}"> {{ $category->name }} </a></td>
            <td><a href="{{ route('category.show', $category->id) }}"> {{ $category->label }} </a></td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->products->count() }}</td>
        </tr> 
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Sem registos ...
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="6">  {{ $categories->appends(request()->input())->links() }} </td>
        </tr>
    </tfoot>
</table> 
@endsection