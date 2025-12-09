 <form class="form-horizontal" method="POST"  name="childrenData">
        {{ csrf_field() }}
        <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <td colspan="4">
                        <div id="result"></div>
                    </td>
                </tr>
                <tr>
                    <th>Cod.</th>
                    <th>Nome</th>
                    <th>Preço Actual</th>
                    <th>Novo Preço</th>
                </tr>
            </thead>
            <tbody>
            	@forelse($children as $child)
                @php
                $product = $child->productByChild;
                @endphp
            	<tr>
            		<td>{{ $product->barcode }}</td>
            		<td>
                        <input type="text" name="product_name[]" value="{{ $product->name }}">
                    </td>
            		<td>{{ number_format($product->price, 2) }}</td>
            		<td>
                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
            			<input type="text" name="product_price[]"  value="{{ $product->price }}" size="8">
            		</td>
            	</tr>



            	@empty

            	<tr>
            		<td colspan="4" style="text-align: center;"> sem registos ...</td>
            	</tr>
            	@endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">                    
                        <button type="button" class="btn btn-primary pull-right form-control" onclick="updateChildren()">
                            <i class="fa fa-check-circle"> finalizar</i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
</form>