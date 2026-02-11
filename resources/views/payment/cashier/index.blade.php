<div>
    <x-simple-card message="Lista de caixas"></x-simple-card>
    <div class="w3-card">
        <table class="w3-table-all w3-table-responsive w3-small w3-section">
            <thead>
                <tr class="w3-theme">
                    <th>#</th>
                    <th>@lang('messages.cashier.startime')</th>
                    <th>@lang('messages.cashier.user_id')</th>
                    <th>@lang('messages.cashier.present')</th>
                    <th>@lang('messages.entity.cashflow')</th>
                    <th>@lang('messages.prompt.closed') ?</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashiers as $key =>$cashier)
                <tr class="w3-hover-theme">
                    <td>{{$key+1}}</td>
                    <td><a href="{{ route('cashier.show', $cashier->id) }}"> {{ $cashier->startime->format('d-m-Y') }}</a></td>
                    <td><a href="{{ route('cashier.show', $cashier->id) }}"> {{ $cashier->user->name }}</a></td>
                    <td><a href="{{ route('cashier.show', $cashier->id) }}"> {{ number_format($cashier->present, 2) }}</a></td>
                    <td class="text-center btn-group-sm">
                        <a href="{{ route('report.cashier.cashflow', ['id' => $cashier->id]) }}" class="btn btn-danger">
                            <i class="fa fa-print"> </i>
                        </a>
                    </td>
                    <td class="text-center btn-group-sm">
                        <i class="fas fa-{{ $cashier->endtime != null ? 'check-circle text-success' : 'times-circle text-danger'}}"></i>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        @lang('messages.prompt.no_records')
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>