<table class="table table-bordered table-striped table-hover table-sm table-responsive-sm">
    <thead>
        <tr>
            <th style="max-widh: 10px;">#</th>
            <th>@lang('messages.item.product')</th>
            <th>@lang('messages.item.quantity')</th>
        </tr>
    </thead>
    <tbody id="tbody">    
        @php
        $articles = $loan->articles;
        @endphp
        @forelse($articles as $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>{{ $article->name }}</td>
            <td>{{ number_format($article->quantity ?? 0, 2) }}</td>

        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Sem registos</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Total</td>
            <td>{{ number_format($articles->sum('quantity')?? 0, 2) }}</td>
        </tr>
    </tfoot>

</table>