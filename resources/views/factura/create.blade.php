<div>
    <div x-data="facturacaoApp()">

        <div class="w3-section w3-grid" style="grid-template-columns: 20% auto; gap: 8px;">

            <div class="w3-card w3-white w3-padding w3-round w3-margin-bottom">
                <div class="">
                    <h4 class="w3-border-bottom w3-padding-small w3-flex" style="gap: 4px; align-items: center;">
                        <i class="fas fa-user-circle"></i>
                        <x-label value="Cliente" />
`
                    </h4>
                    <div class="w3-section">
                        <div class="w3-flex" style="gap: 4px;"><x-label value="Nome" /><x-icon-required /></div>
                        <x-input x-model="customer.name" />
                    </div>
                    <div class="w3-section">
                        <x-label value="NUIT" />
                        <x-input x-model="customer.nuit" />
                    </div>
                    <div class="w3-section">
                        <x-label value="Tel" />
                        <x-input x-model="customer.tel" />
                    </div>
                    <div class="w3-section">
                        <x-label value="Morada" />
                        <x-textarea x-model="customer.address"></x-textarea>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col w3-right-align" style="display: flex; align-items: center; justify-content: space-between;">
                        <x-button @click="cancelarTudo()" class="w3-red">
                            <i class="fas-times-circle"></i> cancelar
                        </x-button>
                        <x-action-button @click="enviarParaAPI()">
                            <i class="fas fa-check"></i> Finalizar
                        </x-action-button>
                    </div>
                </div>
            </div>

            <div class="w3-card w3-white w3-padding w3-round">
                <div class="w3-container w3-right-align w3-margin-top w3-pale-blue w3-padding w3-round">
                    <div class="w3-border-bottom w3-padding-small w3-flex" style="align-items: center; justify-content: space-between;">
                        <div>
                            <h4 class=""><b>Itens</b></h4>
                        </div>
                        <div>
                            <p class="w3-margin-0">Subtotal: <span x-text="calcularSubtotal().toFixed(2)"></span></p>
                            <h3 class="w3-margin-0"><b>Total: <span x-text="calcularTotal().toFixed(2)"></span></b></h3>
                        </div>
                    </div>
                </div>
                <div class="w3-section">
                    <label> <i class="fas fa-search"></i> Pesquisar Produto</label>
                    <input class="w3-input w3-border w3-round"
                        type="text"
                        x-model="busca"
                        @input.debounce.300ms="filtrarProdutos()"
                        placeholder="Comece a digitar o nome do produto...">

                    <div x-show="carregando" class="w3-small w3-text-blue w3-margin-top">A pesquisar na base de dados...</div>

                    <template x-if="produtosFiltrados.length > 0">
                        <div class="w3-white w3-card-4 autocomplete-list w3-round">
                            <ul class="w3-ul w3-hoverable">
                                <template x-for="p in produtosFiltrados" :key="p.id">
                                    <li @click="seleccionarProduto(p)" class="pointer w3-padding-small">
                                        <span x-text="p.name"></span>
                                        <span class="w3-right w3-tag w3-light-grey" x-text="p.price.toFixed(2)"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>

                <div class="w3-responsive">
                    <table class="w3-table w3-bordered w3-border">
                        <tr class="w3-light-grey">
                            <th>Descrição</th>
                            <th class="w3-center" style="width:100px">Qtd</th>
                            <th class="w3-right-align">P. Unit</th>
                            <th class="w3-right-align">Total</th>
                            <th></th>
                        </tr>
                        <template x-for="(item, index) in itemsFactura" :key="index">
                            <tr>
                                <td x-text="item.name"></td>
                                <td><input type="number" x-model.number="item.quantity" min="1" class="w3-input w3-border w3-padding-small w3-center"></td>
                                <td class="w3-right-align" x-text="item.price.toFixed(2)"></td>
                                <td class="w3-right-align font-bold" x-text="(item.price * item.quantity).toFixed(2)"></td>
                                <td class="w3-center"><button @click="removerItem(index)" class="w3-button w3-text-red">&times;</button></td>
                            </tr>
                        </template>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>