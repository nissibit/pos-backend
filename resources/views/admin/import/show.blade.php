@extends('admin.index')
@section('content-admin')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card card-primary">
                <div class="card-heading">
                    <i class="fa fa-eye"> Ver Perfil</i>
                    <a href="{{ route("home") }}" class="btn btn-sm btn-default pull-right">
                        <i class="fa fa-arrow-left"> bloco anterior</i>
                    </a>
                </div>

                <div class="card-body">
                @if(session("info"))
                    <div class="alert alert-info">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-info-circle"> {{ session("info") }}</i>
                    </div>
                @endif
                @if(session("sucesso"))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-check-circle"> {{ session("sucesso") }}</i>
                    </div>
                @endif
                @if(session("falha"))
                    <div class="alert  alert-danger">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-times-circle"> {{ session("falha") }}</i>
                    </div>
                @endif
                    <form class="form-horizontal" method="POST" action="{{ route('import.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome/Designação </label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $import->name }}" readonly="readonly" >
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="alias" class="col-md-4 control-label">Sigla </label>

                            <div class="col-md-6">
                                <input id="alias" type="text" class="form-control" name="alias" value="{{ $import->label }}"  readonly="readonly" >
                              
                                @if ($errors->has('label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <textarea id="description" type="description" class="form-control" name="description" readonly="readonly">{{ $import->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">
                            <label for="created_at" class="col-md-4 control-label">Criado</label>

                            <div class="col-md-6">
                                <textarea id="created_at" type="created_at" class="form-control" name="created_at" readonly="readonly">{{ $import->created_at }}</textarea>
                                @if ($errors->has('created_at'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('created_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('updated_at') ? ' has-error' : '' }}">
                            <label for="updated_at" class="col-md-4 control-label">Actualizado</label>

                            <div class="col-md-6">
                                <textarea id="updated_at" type="updated_at" class="form-control" name="updated_at" readonly="readonly">{{ $import->updated_at }}</textarea>
                                @if ($errors->has('updated_at'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('updated_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="button" class="btn btn-outline-secondary pull-right">
                                    <i class="fa fa-file-pdf text-danger"> pdf</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
