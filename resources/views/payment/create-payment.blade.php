<div class="w3-container w3-section">
    <div class="w3-card-2 w3-leftbar w3-rightbar w3-padding w3-border-theme">
        <div class="w3-grid w3-theme-l4 w3-padding" style="gap:8px;grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); font-size: 2rem;">
            <div class="w3-grid w3-border-right"><x-label value="Nr. Factura" /> <x-text :value="$factura->id" /></div>
            <div class="w3-grid w3-border-right"><x-label value="Cliente" /> <x-text :value="$factura->customer_name" /></div>
            <div class="w3-grid w3-border-right"><x-label value="NUIT" /> <x-text :value="$factura->customer_nuit" /></div>
            <div class="w3-grid"><x-label value="TEL" /> <x-text :value="$factura->customer_phone" /></div>
        </div>
        <hr>
        <div class="w3-grid" style="grid-template-columns: max-content auto;">
            <div class="w3-container">
                <form action="{{route('payment.store')}}" id="form_create_payment" method="post" class="w3-grid-padding" style="gap: 4px;">
                    @csrf
                    <input type="hidden" name="facturaId" id="facturaId" value="{{$factura->id}}" />
                    <input type="hidden" name="payment_dueAmount" id="payment_dueAmount" value="{{$factura->total}}" />
                    <input type="hidden" name="payment_received" id="payment_received" value="0" />
                    <input type="hidden" name="payment_changes" id="payment_changes" value="0" />
                    @foreach ($methods as $key => $method)
                    <div class="w3-grid" style="gap:8px; grid-template-columns: 1fr auto;">
                        <label for="" class="w3-label">{{$method}}</label>
                        <x-input
                            type="number"
                            step="0.01"
                            min="0"
                            class="payment_method" />

                    </div>
                    @endforeach
                    <div class="w3-section w3-grid" style="grid-template-columns: 1fr 1fr;">
                        <div>
                            <x-button onclick="form_create_payment.reset()" class="w3-red w3-left">
                                <i class="fas fa-times"></i> Cancelar
                            </x-button>
                        </div>
                        <div>
                            <x-action-button type="button" id="btnSavePayment" class="w3-block">
                                <i class="fas fa-check-circle"></i> Finalizar
                            </x-action-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="w3-container w3-padding" style="font-size: 2.5rem;">
                <div class="w3-grid-padding">
                    <div class="w3-grid w3-theme-l5 w3-card-4 w3-padding" style="gap:8px; grid-template-columns: 1fr auto;">
                        <x-label value="Por pagar" />
                        <label for="" class="w3-label">{{number_format($factura->total,2 )}}</label>
                    </div>
                    <div class="w3-grid w3-theme-l4 w3-card-4 w3-padding" style="gap:8px; grid-template-columns: 1fr auto;">
                        <x-label value="Recebido" />
                        <label for="" class="w3-label" id="payment_received_label">{{number_format(0, 2)}}</label>
                    </div>
                    <div class="w3-grid w3-theme-l3 w3-card-4 w3-padding" style="gap:8px; grid-template-columns: 1fr auto;">
                        <x-label value="Trocos" />
                        <label for="" class="w3-label" id="payment_changes_label">{{number_format(0, 2)}}</label>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-modal>
        <x-slot:title>
            <div class="w3-flex" style="align-items: center; gap: 4px;">
                <div><i class="fas fa-save"></i></div>
                <div>
                    <h3>Pagamento da factura</h3>
                </div>
            </div>
        </x-slot:title>
        <x-slot:footer>
            <div class="w3-section w3-grid" style="grid-template-columns: 1fr 1fr;">
                <div>
                    <x-button onclick="toggleModal('modal', false); " class="w3-red w3-left">
                        <i class="fas fa-times"></i> fechar
                    </x-button>
                </div>
                <div>
                    <x-action-button type="button" onclick="printPDF()" id="btnPrintPDF" class="w3-block">
                        <i class="fas fa-print"></i> imprimir recibo
                    </x-action-button>
                </div>
            </div>
        </x-slot:footer>
    </x-modal>
</div>