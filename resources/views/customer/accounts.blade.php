<div class="card">
    <?php
    $total = $customer->account()->count();
    $accounts = $customer->account()->latest()->paginate(10);
    ?>
    <div class="card-header">
        {{ "Total :#".$total }}
    </div>
    @if($accounts->count() == 0 )
    <div class="card-header">
        <h2>Criar Conta</h2>
        <form  role="form" autocomplete="off" action="{{ route('account.store') }}" method="post" class="m-sm-1">
            {{ csrf_field() }}
            <div class="row">
                <div class="col input-group-sm input-group">
                    <label>Desconto:</label><br />
                    <input type="text" name="discount" class="form-control @error('') is-invalid @enderror" placeholder="desconto" required=""  value="{{ old('discount', $account->discount ?? '0') }}" />
                    <input type="hidden" name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" placeholder="cliente" required=""  value="{{ old('customer_id', $customer->id ?? '0') }}" />                        
                    @error('customer_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>                                  
                <div class="col input-group-sm input-group">
                    <label>Dias de Pag:</label><br />
                    <input type="text" name="days" class="form-control @error('days') is-invalid @enderror" placeholder="desconto" required=""  value="{{ old('days', $account->days ?? '30') }}" />                      
                    @error('days')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>                                  
                <div class="col input-group-sm input-group">
                    <label>Preço Extra:</label><br />
                    <input type="text" name="extra_price" class="form-control @error('extra_price') is-invalid @enderror" placeholder="desconto" required=""  value="{{ old('extra_price', $account->extra_price ?? '5') }}" />                       
                    @error('extra_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>  
                <div class="col">
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-plus-circle"> criar conta</i>
                        </button>
                    </span>
                </div>
            </div>                                  
        </form>
    </div>
    @endif
    <div class="card-body">

        <table class="table table-bordered table-hover table-responsive-sm table-sm">           
            <thead>
                <tr>
                    <th>#</th>
                    <th>Credit</th>
                    <th>Debito</th>
                    <th>Saldo</th>
                    <th>Desconto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $key => $account)

                <tr>
                    <td><a href="{{ route('account.show', $account->id) }}"> {{ $account->id }}</a></td>
                    <td class="text-right">{{ number_format($account->credit ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($account->debit ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($account->balance ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($account->discount ?? 0, 2) }}</td>                    
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center"> Sem registos ...</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-center">
        {{ $accounts->appends(request()->input())->links() }}
    </div>
</div>
