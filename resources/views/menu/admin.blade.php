<div class="col-sm-2 sidenav" style="background-color: transparent;">
    <div class="list-group text-left">
        <a href="#" class="list-group-# active"><i class="fa fa-home"> Administrador</i></a>

        @can("menu_entidade")<a href="{{ route('entidade.index') }}" class="list-group-#"><i class="fa fa-user-plus"> Entidade</i></a>@endcan
        @can("menu_matricula")<a href="{{ route('matricula.index') }}" class="list-group-#"><i class="fa fa-file-word-o"> Matricula</i></a>@endcan
        @can("menu_pagamento")<a href="{{ route('pagamento.index') }}" class="list-group-#"><i class="fa fa-money"> Pagamentos</i></a>@endcan

        @can("menu_aluno")<a href="{{ route('aluno.index') }}" class="list-group-#"><i class="fa fa-user"> Aluno</i></a>@endcan
        @can("menu_professor")<a href="#" class="list-group-#"><i class="fa fa-user-secret"> Professor</i></a>@endcan
        @can("menu_encaregado")<a href="{{ route('encaregado.index') }}" class="list-group-#"><i class="fa fa-group"> Encarregado</i></a>@endcan
        @can("menu_curso")<a href="{{ route('curso.index') }}" class="list-group-#"><i class="fa fa-graduation-cap"> Curso</i></a>@endcan
        @can("menu_disciplina")<a href="{{ route('disciplina.index') }}" class="list-group-#"><i class="fa fa-book"> Disciplina</i></a>@endcan
        @can("menu_curriculo")<a href="{{ route('curriculo.index') }}" class="list-group-#"><i class="fa fa-cube"> Curriculo</i></a>@endcan
        @can("menu_sala")<a href="{{ route('sala.index') }}" class="list-group-#"><i class="fa fa-cubes"> Sala</i></a>@endcan

        @can("menu_regime")<a href="{{ route("regime.index") }}" class="list-group-#"><i class="fa fa-clock-o"> Regime</i></a>@endcan
        @can("menu_turma")<a href="{{ route("turma.index") }}" class="list-group-#"><i class="fa fa-group"> Turma</i></a>@endcan
        @can("menu_propina")
        <a href="#collapse1" data-toggle="collapse" class="list-group-#"><i class="fa fa-money"> Propinas</i></a>
        <div id="collapse1" class="collapse">
            <ul class="list-group">
                <a href="{{ route("propina.index") }}" class="list-group-# list-group-#-success">Gerir</a>
                <a href="{{ route("tipopropina.index") }}" class="list-group-# list-group-#-success">Tipos</a>                
            </ul>
        </div>
        @endcan        
        @can("menu_taxa")<a href="{{ route("taxa.index") }}" class="list-group-#"><i class="fa fa-dollar"> Taxas</i></a>@endcan
        @can("menu_admin")
        <a href="{{ route('entidadebancaria.index') }}" class="list-group-#"><i class="fa fa-building"> Bancos</i></a>
        <a href="{{ route('admin') }}" class="list-group-#"><i class="fa fa-cog"> Config</i></a>
        @endcan

    </div>
</div>