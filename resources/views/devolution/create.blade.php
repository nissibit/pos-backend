@extends('devolution.indexDevolution')
@section('content-devolution')
<style type="text/css">
    input[readonly="readonly"]{
        font-weight: bold;
    }
</style>
<div class="card">
    <form class="form-horizontal" method="POST" action="{{ route('devolution.store') }}">
        {{ csrf_field() }}
        <input type="hidden" class="form-control" name="loan_id" id="loan_id" value="{{ old('loan_id', $loan->id ?? '') }}"   />                

        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3><i class="fa fa-plus-circle"> </i> Pagamento do Empréstimo</h3>
                </div>
                <div class="col-sm-3 text-right">
                    <h2 id="QtdItems"></h2>
                </div>
            </div>
        </div>
        <style>
            input[readonly="readonly"]{
                font-weight: bold;        
                color: black;
            }
        </style>
        <div class="card-body" id="tabela-result">
            <table class="table table-bordered table-striped table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Quantidade a Devolver</th>
                        <th>Por devolver</th>
                    </tr>
                </thead>
                <tbody id="tbody">               
                    @forelse($articles ?? [] as $article)
                    <tr>
                        <td>{{ $article->barcode }}</td>
                        <td>{{ $article->name }}</td>
                        <td>
                            <input value="{{ old('article_'.$article->id, '0')}}" name="article_{{ $article->id }}" type="text"  />
                        </td>
                        <td>{{ ($article->quantity - $article->devolutions->sum('quantity')) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Sem registos</td>
                    </tr>
                    @endif
                </tbody>

            </table>
        </div>
        <div class="col-sm input-group-sm">
            <label for="description" class="control-label">Descrição</label>
            <textarea id="description"  name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description', $devolution->description ?? '') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>   
        <div class="card-footer">
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp; </label>
                    <button type="button" class="btn btn-success pull-right form-control" onclick="submitForm(this);">
                        <i class="fa fa-check-circle"> @lang('messages.prompt.finish')</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm btn-group-sm ">
                    <label for="total">&nbsp;</label>
                    <a href="{{ route('cancel.items') }}" class="btn btn-danger pull-right form-control">
                        <i class="fa fa-times-circle"> @lang('messages.prompt.cancel')</i>
                    </a>
                </div>
            </div>
        </div>



    </form>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){ 
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
        });
    });
    function submitForm(btn) {
        btn.disabled = true;
        btn.form.submit();
    }
</script>
@endsection
