<?php
$children = $product->children()->latest()->paginate(10);
?>
<table class="table table-bordered table-hover table-responsive-sm table-sm">
    <thead>
        <tr>
            <th>Cod. Barras.</th>
            <th>Produto</th>
            <th>Preço</th>
            <th>Qtd. Vendidas</th>
            <th>Redução</th>
            <th>Edição</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($children as $parent)
        @php
        $child = \App\Models\Product::find($parent->child);
        @endphp
        @if($child != null)
        <tr>
            <td><a href="{{ route('product.show', $child->id) }}">{{ $child->barcode }}</a></td>
            <td><a href="{{ route('product.show', $child->id) }}">{{ $child->name ?? 'N/A' }}</a></td>
            <td><a href="{{ route('product.show', $child->id) }}">{{ number_format($child->price ?? 0, 2) }}</a></td>
            <td><a href="{{ route('product.show', $child->id) }}">{{ number_format($parent->sales ?? 0, 2) }}</a></td>
            <td><a href="{{ route('product.show', $child->id) }}">{{ number_format($parent->quantity ?? 0, 3) }}</a></td>
            <td class="btn-group-sm">
                <button class="btn btn-outline-info" title="Editar Produto" onclick="callModalEdit('{{ $child->id }}')">
                    <i class="fa fa-cube"></i>
                </button> &nbsp;
                <button class="btn btn-outline-success" title="Editar Preço" onclick="callModalPrice('{{ $child->id }}')">
                    <i class="fa fa-dollar-sign"></i>
                </button> &nbsp;
            </td>
            <td class="btn-group-sm">
                <a href="{{ route('product.child.destroy', $parent->id) }}" class="btn btn-outline-danger ml">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endif
        @empty
        <tr>
            <td colspan="7" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>   
    <tfoot>
        <tr>
            <td colspan="7" class="text-center">  {{ $children->appends(request()->input())->links() }}</td>
        </tr>
    </tfoot>
</table>