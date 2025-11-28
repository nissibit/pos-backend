<div class="card mt-2">
    <div class="card-header">
        <h1><i class="fa fa-clock"> </i>Histórico das facturas removidas</h1>
    </div>
    <div class="card-body">
        <div class="form-group col-sm-3 input-group-sm">
            <form id="factura_search" role="form" autocomplete="off" action="{{ route('factura.history.destroy') }}" method="get">
                <div class="input-group-sm input-group">
                    <label for="date" class="form-label-left">Data <i class="fas fa-asterisk text-danger"></i> </label>
                    <input type="text" name="date" class="form-control datepicker" placeholder="pesquisa avançada" required=""  value="{{ old('date', \Carbon\Carbon::today()->format('Y-m-d')) }}" >
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"> </i>
                        </button>
                    </span>
                </div>                                  
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
     document.addEventListener('DOMContentLoaded', function(){ 

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0D',
        changeYear: true,
        changeMonth: true
    });
    });
</script>