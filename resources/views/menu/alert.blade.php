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