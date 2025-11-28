@extends("creditnote.indexCreditNote")
@section("content-creditnote")
<div class="row">
    <div class="col-sm-2 text-center">
        <i class="fa fa-dollar-sign fa-5x"></i>
        <p>
            <label class="control-label"><?php echo strtoupper("{$creditnote->name}"); ?></label><br />
            <label class="control-label"><?php echo "#{$creditnote->id}"; ?></label><br />
            <label class="control-label"><?php echo "Código : {$creditnote->id}"; ?></label><br />
            <small>Entidade desde <?php echo $creditnote->created_at->diffForHumans(); ?></small>
        </p>
        @can('audit_creditnote')
        <form role='form' action="{{ route('audit.entity') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $creditnote->id }}"  />
            <input type="hidden" name="model" value="\App\Models\CreditNote"  />
            <input type="hidden" name="name" value="{{ $creditnote->customer_name }}"  />
            <button type="submit" class="btn btn-primary">            
                <i class="fa fa-user-shield"> auditar</i>
            </button>
        </form>
        @endcan
    </div>
    <div class="col border-primary">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#tab_1" data-toggle="tab" class="nav-item nav-link active"><i class="fa fa-info text-dark"></i> Informação</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1" aria-labelledby="nav-contact-tab">
                <div class="row">
                    <div class="col">
                        @include('creditnote.info')
                    </div>                  
                </div>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-info">
                            <strong>Documento serve somente para levantar material</strong>
                        </div>
                        <iframe src="{{  route('report.creditnote', ['id' => $creditnote->id, 'm' => 'a5']) }}" width="100%" height="600px">
                        </iframe>
                    </div>
                </div>

            </div>
         </div>
        <!-- /.tab-content -->
    </div>
</div>
@endsection
