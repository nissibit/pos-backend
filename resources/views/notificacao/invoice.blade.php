@component("mail::message")
<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-info-circle 3x"></i>  
    </div>  
    @component("mail::panel")
    <div class="panel-body">
        Saudações!
        Vimos por meio desta informar ao sr(a) {{ $encaregado->name }} que o(s) aluno(s)
        @foreach($encaregado->entidades as $entidade)
            {{ $entidade->firstname." ".$entidade->lastaname.", "}}
        @endforeach
        encontram-se em bons cuidados.
    </div>
    @endcomponent    

</div>
@endcomponent