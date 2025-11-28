@extends('admin.index')
@section('content-admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-heading">
                    <i class="fa fa-user-shield"> Atribuindo profissão </i>
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
                    <form class="form-horizontal" method="POST" action="{{ route('profissao-set-store') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} input-group-sm">
                            <div class="col-md-6">
                                <label for="user_id" class="control-label">Cliente <b class="text-danger"> *</b></label>
                                <div class="">
                                    <select id="user_id" type="text" class="form-control selectpicker" name="user_id"  required data-live-search="true" title="Seleccione utilizador">
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div> 
                            </div> 

                            <div class="col-md-6">
                                <label for="" class="control-label">&nbsp;</label><br />

                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fa fa-plus-circle"> adicionar</i>
                                </button>
                            </div> 
                        </div>    
                        <div class="responsive">
                            <table class="table table-bordered table-responsive table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="selectAll(this.checked)" /></th>
                                        <th>Profissao</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profissaos as $profissao)
                                    <tr>
                                        <td><input type="checkbox" name="profissao_id[]" id="{{ $profissao->id }}" value="{{ $profissao->id }}" /></td>
                                        <td>{{ $profissao->name }}</td>
                                        <td>{{ $profissao->description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </form>   
                </div>                 

            </div>                       
        </div>
        <div class="col-md-6">
            <div class="card card-default">

                <div class="card-heading">
                    <i class="fa fa-list"> Ver dados</i>
                    <a href="{{ route("home") }}" class="btn btn-sm btn-default pull-right">
                        <i class="fa fa-arrow-left"> bloco anterior</i>
                    </a>
                </div>   

                <div class="card-body">
                    @if(session("infoo"))
                    <div class="alert alert-info">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-info-circle"> {{ session("infoo") }}</i>
                    </div>
                    @endif
                    @if(session("sucessoo"))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-check-circle"> {{ session("sucessoo") }}</i>
                    </div>
                    @endif
                    @if(session("falhaa"))
                    <div class="alert  alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-times-circle"> {{ session("falhaa") }}</i>
                    </div>
                    @endif
                    <div class="responsive">
                        @can('show_set_profissao')
                        <table id="exampleThis" class="table table-bordered table-responsive table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Utilizador</th>
                                    <th>Profissao(is)</th>
                                    <th>Operação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @foreach($user->profissaos as $profissao)
                                        <a href="#" data-type="checklist" data-value="{{$profissao->id}}" data-title="Select profissão s" data-name="profissao" class="profissao" data-pk="{{$profissao->id}}" profissão ="button">
                                            <span class="label label-primary">{{$profissao->name}}</span>
                                        </a>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('delete_set_profissao')
                                        <a href="#" rel="popover" data-placement="left"  title="Eliminar profissão :"  data-popover-content="#{{ $user->id.'-'.$profissao->id }}" class="links">
                                            <i class="fa fa-trash text-danger"></i>                            
                                        </a>
                                        <div id="{{ $user->id.'-'.$profissao->id }}" class="hide">
                                            @foreach($user->profissaos as $profissao)
                                            <form  action="{{ route('profissao-set-delete') }}" method="post">
                                                {{ csrf_field() }} 
                                                <input type="hidden" name="user_idd" value="{{ $user->id }}"/>
                                                <input type="hidden" name="profissao_idd" value="{{ $profissao->id }}"/>
                                                <button  type="submit" class="btn btn-link">{{$profissao->name}}</button>
                                            </form>
                                            @endforeach                                            
                                        </div>
                                        @endcan
                                    </td>

                                    @endforeach
                            </tbody>
                        </table>
                        @endcan
                    </div>
                </div>

                <div class="card-footer">
                    Dados de profissão  seleccionado
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('post-script')
<script>
    function selectAll(obj) {
        var op = document.getElementsByName("profissao_id[]");
        for (i = 0; i < op.length; i++) {
            op[i].checked = obj;
        }
    }
    $(document).ready(function () {
        $('#exampleThis').DataTable({
            dom: 'frtp'
        });
    });
</script>
@endsection