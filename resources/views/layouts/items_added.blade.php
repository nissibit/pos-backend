<table class="table table-bordered table-striped table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th style="max-widh: 10px;">@lang('messages.item.delete')</th>
            <th>@lang('messages.item.product')</th>
            <th>@lang('messages.item.quantity')</th>
        </tr>
    </thead>
    <tbody id="tbody">               
        @forelse($temps ?? [] as $temp)
        <tr>
            <td class="text-center">
                <button type="button" class="btn btn-group-sm" onclick="getData('{{ $temp->product_id }}', 1, 'id');"><i class="fa fa-arrow-up text-success"></i></button> 
                <button type="button" class="btn-group-sm" onclick="getData('{{ $temp->product_id }}', 0, 'id');"><i class="fa fa-times-circle text-danger"></i></button>       
                <button type="button" class="btn btn-group-sm" onclick="getData('{{ $temp->product_id }}', - 1, 'id');"><i class="fa fa-arrow-down text-danger"></i></button>
            </td>
            <td>{{ $temp->name }}</td>
            <td>
                <input value="{{ $temp->quantity }}" id="{{ $temp->id }}" type="text"  onblur="getData('{{ $temp->product_id }}', 99, 'id', this.value);"  />
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Sem registos</td>
        </tr>
        @endif
    </tbody>

</table>