<div class="row">
    <div class="form-group  btn-group-sm">
        <a href="{{ route('user.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-user">  @lang('messages.entity.user')</i>
        </a> 
        <a href="{{ route('role.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-file"> @lang('messages.entity.role')</i>
        </a> 
        <a href="{{ route('permission.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-shield"> @lang('messages.entity.permission')</i>
        </a> 
        <a href="{{ route('audit.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-user-shield"> @lang('messages.entity.audit')</i>
        </a> 
        <a href="{{ route('restore.index') }}" class="btn btn-outline-primary  ">
            <i class="fas fa-compress"> @lang('messages.entity.restore')</i>
        </a>
        <a href="{{ route('company.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-building"> @lang('messages.entity.company')</i>
        </a>
        <a href="{{ route('currency.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-coins"> @lang('messages.entity.currency')</i>
        </a>
        <a href="{{ route('exchange.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-exchange-alt"> @lang('messages.entity.exchange')</i>
        </a>
      
        <a href="{{ route('import.index') }}" class="btn btn-outline-primary ">
            <i class="fas fa-upload"> @lang('messages.entity.import') </i>
        </a>
        
        <a href="{{ route('audit.factura.trashed') }}" class="btn btn-outline-danger ">
            <i class="fas fa-trash"> @lang('messages.entity.factura') </i>
        </a>
    </div>    
</div> 