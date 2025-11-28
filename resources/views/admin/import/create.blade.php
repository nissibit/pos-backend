@extends('admin.import.indexImport')
@section('content-import')

<div class = "card">
    <div class = "card-header">
        <i class = "fa fa-user fa-plus-circle"> {{ __('Importar Dados de ') }} <strong>{{ $table ?? ''}}</strong></i>
    </div>
    <div class="card-header">
        {{ __('Estrutura da tabela') }}
        <?php
        echo '<table class="table table-sm table-bordered"><tbody><tr>';
        foreach ($tableDesc as $col) {
            if (!in_array($col->Field, array('id', 'created_at', 'updated_at', 'deleted_at'))) {
                echo "<td>"
                ?> @lang("messages.{$table}.{$col->Field}")<?php
                echo "</td>";
            }
        }
        echo '</tbody></table></tr>';
        ?>
    </div>
    <div class = "card-body">

        <form action="{{ route('import.store') }}" name="upload" id="upload" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}           
            <div class="form-group col-sm-6 input-group-sm btn-group btn-group-sm">
                <input type="hidden" name="table" id="table" value="{{ $table }}"  />
                <input type="hidden" name="model" id="table" value="{{ $model }}"  />
                <input type="file" name="file" id="file" class="file" title="Carregar ficheiro do banco">
                <button type="submit" class="btn btn-outline-primary ">
                    {{ __('Carregar') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
