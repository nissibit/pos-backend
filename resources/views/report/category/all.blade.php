@include('report.header')
<style>
    body{
        font-family: 'arial';
        font-size:11px;
    }
</style>
<div class="card">
    <?php
    $total = $categories->count();
    ?>
    <div class="card-body">
        <table border="1" cellspacing="0" cellpadding="2" width="100%" > 
            <thead>
                <tr>
                    <th colspan="5">Lista de categorias #{{$total}}</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Designação</th>
                    <th>Abreviatura</th>
                    <th>Descrição</th>
                    <th>Produtos(#)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->label }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->products->count() }}</td>
                </tr> 
                <?php $i++; ?>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <table style="width:100%;">
            <tr>
                <td colspan="3" style="text-align: left">
                    <strong>{{ 'Utilizador: '.auth()->user()->name }}</strong>
                </td>
                <td colspan="2" style="text-align: right; border-left: 0px solid;">
                    <strong>{{ \carbon\Carbon::now()->format('d-m-Y h:m:i') }}</strong>
                </td>
            </tr> 
        </table>
    </div>    
</div>
