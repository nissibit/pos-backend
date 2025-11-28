<style>
    input[readonly="readonly"]{
        font-weight: bold;        
        color: black;
    }
</style>
<div class="card">
    
    <div class="card-body">
        <div class="col input-group-sm input-group">
            <input type="text" name="from" id="from" class="form-control datepicker" placeholder="data inicio" required=""  value="{{ old('from', $dados['from_search'] ?? '') }}" readonly="readonly" />
            <label>&nbsp;para&nbsp;</label>
            <input type="text" name="to" id="to" class="form-control datepicker" placeholder="data fim" required=""  value="{{ old('to', $dados['to_search'] ?? '') }}" readonly="readonly" />        
            &nbsp;
            <form id="audit_search" role="form" autocomplete="off" action="{{ route('audit.entity.search') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $audits->first() != null ? $audits->first()->auditable_id : 1 }}"  />
                <input type="hidden" name="model" value="\App\Models\Product"  />
                <input type="hidden" name="name" value="{{ $user->name }}"  />
                <input type="hidden" name="from_search" id="from_search" class="form-control datepicker" placeholder="data inicio" required=""  value="{{ old('from_search', request()->get('from_search') ?? '') }}" />
                <input type="hidden" name="to_search" id="to_search" class="form-control datepicker" placeholder="data fim" required=""  value="{{ old('to_search', $dados['to_search'] ?? '') }}" />                   
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </form>
            &nbsp;
            <form id="audit_print" role="form" autocomplete="off" action="{{ route('audit.entity') }}" method="post">            
                {{ csrf_field() }}
                <input type="hidden" name="from_print" id="from_print" class="form-control datepicker" placeholder="data inicio" required=""  value="{{ old('from_print', $dados['from_print'] ?? '') }}" />
                <input type="hidden" name="to_print" id="to_print" class="form-control datepicker" placeholder="data fim" required=""  value="{{ old('to_print', $dados['to_print'] ?? '') }}" />                                   
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-danger btn-group-sm" type="submit">
                        <i class="fas fa-print"> </i>
                    </button>
                </span>
            </form>
        </div>                                  
    </div>  
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
    });
    $('#from, #to').on('change', function () {
        var id = this.id;
        var value = this.value;
        if (id === 'from') {
            $('#from_search').val(value);
            $('#from_print').val(value);
        }
        if (id === 'to') {
            $('#to_search').val(value);
            $('#to_print').val(value);
        }
    });
</script>