<div class="card">
    <?php
    #$children = $product->parents()->latest()->paginate(10);
    $children = \App\Models\ProductChild::where('child', $product->id)->paginate(10);
    #dd($children);
    ?>
    <div class="card-body">

        <table class="table table-bordered table-hover table-responsive-sm table-sm">
            <thead>
                <tr>
                    <th>Cod. Barras.</th>
                    <th>Produto</th>
                    <th>Stock</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                @forelse($children as $parent)
                @php
                $child = \App\Models\Product::find($parent->parent);
                @endphp
                @if($child != null)
                <tr>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->barcode }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->name ?? 'N/A' }}</a></td>
                    <td class="text-right"><a href="{{ route('mother.show', $product->id) }}"> {{ number_format($child->stock()->first()->quantity ?? 0, 2) }}</a></td>
                    <td><a href="{{ route('product.show', $child->id) }}">{{ $child->category->name ?? 'N/A' }}</a></td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="4" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>   
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center">  {{ $children->appends(request()->input())->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
