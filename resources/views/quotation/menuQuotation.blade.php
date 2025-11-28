<div class="row">
    <div class="form-group col btn-group-sm">        
        <?php
        $cashier = auth()->user()->cashier->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        ?>
        <a href="{{ route('quotation.create') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-plus-circle"> criar</i>
        </a>
        <a href="{{ route('quotation.index') }}" class="btn btn-outline-secondary  ml-1">
            <i class="fas fa-list"> listar</i>
        </a>
        @if($enableSend ?? null != null)
        <a  class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="fa fa-envelope"> Enviar por email</i>
        </a>  
        @endif
    </div>
    <div class="form-group col input-group-sm">
        <form id="quotation_search" role="form" autocomplete="off" action="{{ route('quotation.search') }}" method="get" class="m-sm-1">
            <div class="input-group-sm input-group">
                <input type="text" name="criterio" class="form-control" placeholder="pesquisa avançada" required=""  value="{{ old('criterio', $dados['criterio'] ?? '') }}" >
                <span class="input-group-btn btn-group-sm ">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"> </i>
                    </button>
                </span>
            </div>                                  
        </form>
    </div>    
</div>         
<div class="collapse" id="collapseExample">
    <div class="card card-body border-success">
        <form method="post" role="form" action="{{ route('quotation.send') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col form-group input-group-sm">
                    <input id="sent_id" type="hidden" class="form-control @error('sent_id') is-invalid @enderror" name="sent_id" value="{{ $quotation->id ?? '' }}" placeholder="example@site.com"  >
                    @error('sent_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $quotation->email ?? '') }}" placeholder="example@site.com"  >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>               
                <div class="col form-group input-group-sm">
                    <textarea id="description"  type="description"  name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Descrição" >{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col btn-group-sm ">
                    <button type="submit" class="btn btn-success pull-right">
                        <i class="fas fa-send-o"> enviar</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
