<div class="card">
    <div class="card-header">
        <span>Estatística de <strong> {{ $product->name }} </strong>no período {{ $data["from"]." / ".$data["to"] }}</span>
      <!--   <hr />
        <div id="resume">
            <ul style="list-style:none;">
                <li><b>Vendas</b>: <span id="factura"></span></li>
                <li><b>Saídas</b>: <span id="output"></span></li>
                <li><b>Crédito</b>: <span id="credit"></span></li>
                <li><b>Total</b>: <span id="total"></span></li>
            </ul>
        </div> -->
    </div>
    <div class="card-body">
        <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
            <thead class="text-center">
                <tr>
                    <th colspan="3">Qtd: {{ $items->sum('qtd') ?? 0}}</th>
                    <th colspan="2" class="text-right">Total: {{ number_format($items->sum('total') ?? 0, 2) }}</th>
                    <th class="text-right">Vendas: {{ $items->sum('vendas') }}</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Qtd.</th>
                    <th>Preco</th>
                    <th>Total</th>                    
                    <th>#Vendas</th>                    
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $i = 1; ?>
                @forelse($items as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td class="text-right">
                        <div style="display: flex; justify-content: space-between;">
                            <div><span>{{ $item->qtd }}</span></div>
                            <div>
                                <button onclick="getSpecificStatistic(this)" class="btn btn-outline-primary btn-sm" data-id="{{$product->id}}" data-date="{{$item->created_at->format('Y-m-d')}}" data-product-name="{{$product->name}}"><i class="fas fa-info-circle text-primary"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="text-right">{{ number_format(round($item->unitprice/$item->vendas),2) }}</td>
                    <td>{{ number_format($item->total,2) }}</td>
                    <td>{{ $item->vendas }}</td>
                </tr> 
                <?php $i++; ?>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

  <!-- The Modal -->
  <div class="modal fade" id="modalForm" >
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <span class="modal-title" id="modalHeader">Título</span>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="modalBody">
            <table  class="table table-striped table-bordered table-hover table-sm table-responsive-sm" style="width:100%">
               <thead class="text-center">
                    <tr>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Qtd.</th>
                        <th>Preco</th>
                        <th>Total</th>                      
                    </tr>
                </thead>
                <tbody class="text-center" id="tableContent">
                </tbody>
            </table>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>
  <!-- End Modal -->

<script>
    
    async function getSpecificStatistic(el) {
        let id = el.dataset.id;
        let date = el.dataset.date;
        var url = '{{ route("product.specific.statistic", ["date"=>":date", "id"=> ":id"]) }}';
        url =  url.replace(":date", date);
        url =  url.replace(":id", id);

        await fetch(url)
            .then( resp => resp.json() )
            .then( resp => {
                document.getElementById('modalHeader').innerHTML = `Estatística discritiva de <br /><strong>${el.dataset.productName} (${el.dataset.date})</strong>`;
                let content = '';
                for(var i = 0; i < resp.length; i++){
                    content += `
                        <tr>
                            <td>${getMorphName(resp[i].item_type)}</td>
                            <td>${resp[i].created_at.substr(0,10)}</td>
                            <td>${resp[i].qtd}</td>
                            <td>${resp[i].unitprice}</td>
                            <td>${number_format(resp[i].total)}</td>
                        </tr>
                    `;
                }
                document.getElementById('tableContent').innerHTML = content;
                $("#modalForm").modal();

            });
    }

    function getMorphName(name){
        try{
            let tempName = name.split("App\\Models\\")[1].toLowerCase();
            switch(tempName){
                case 'factura': return "Venda";
                case 'output' : return "Saida";
                case 'credit' : return "Crédito";
                default: return "Venda";

            }
        }catch(error){
            console.log(`Ocorreu um erro ao traduzir nome do tipo: ${error}`);
        }
    }

    function openModalTransport(type){
        let _loading = `<div class="container text-center"><i class="fas fa-spinner fa-spin-pulse fa-spin-reverse "></i></div>`;
        let body = document.getElementById("modalBody");
        document.getElementById('modalHeader').innerHTML = `Adicionando ${type}`;
        let url = '{{ route("product.form.editable") }}';
         body.innerHTML = _loading;

        $.ajax({
            'type': 'GET',
            'url': url,
            data: {type:type},
            beforeLoading: function(){
                body.innerHTML = _loading;
            },
            success: function (data) {
               body.innerHTML = data;
            },
            error: function(error){
                body.innerHTML = error;
            }
        });
        $("#modalForm").modal();
    }
</script>