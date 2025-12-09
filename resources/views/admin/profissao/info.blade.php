<div class="row">
    <div class="form-group input-group-sm col-sm-6">
        <strong class="control-label"> @lang('messages.profissao.name'): </strong>
        <label class="control-label"> {{ $profissao->name ?? 'N/A' }} </label>
    </div>
    <div class="input-group-sm col-sm-6">
        <strong class="control-label"> @lang('messages.profissao.alias'): </strong>
        <label class="control-label"> {{ $profissao->alias ?? 'N/A'}} </label>
    </div>
</div>
<div class="row">
    <div class="form-group input-group-sm col-sm-6">
        <strong class="control-label"> @lang('messages.profissao.description'): </strong>
        <label class="control-label"> {{ $profissao->description ?? 'N/A' }} </label>
    </div>
    <div class="input-group-sm col-sm-6">
        <strong class="control-label"> @lang('messages.profissao.created_at'): </strong>
        <label class="control-label"> {{ $profissao->created_at->format('d-m-Y') ?? 'N/A'}} </label>
    </div>
</div>