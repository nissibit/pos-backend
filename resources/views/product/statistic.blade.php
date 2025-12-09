<div class="card">
    <div class="card-header">
        <div class="form-group  input-group-sm">
            <form id="cashier_search" role="form" autocomplete="off" action="{{ route('cashier.search.report') }}" method="get" class="m-sm-1">
                <div class="input-group-sm input-group">
                    <input type="hidden" name="id" id="id" value="{{ $product->id }}"  />
                    <input type="text" name="from" id="from" class="form-control datepicker" placeholder="Y-m-d" required=""  value="{{ old('from', $dados['from'] ?? '') }}" readonly="readonly" /> &nbsp; - &nbsp;
                    <input type="text" name="to" id="to" class="form-control datepicker" placeholder="Y-m-d" required=""  value="{{ old('to', $dados['to'] ?? '') }}" readonly="readonly" />
                    <span class="input-group-btn btn-group-sm ">
                        <button class="btn btn-outline-primary" type="button" onclick="getStatistic()">
                            <i class="fas fa-search"> </i>
                        </button>
                    </span>
                </div>                                  
            </form>
        </div> 
    </div>
    <div class="card-body" id="resume"></div>
    <div class="card-body" id="result">

    </div>

</div>
<script type="text/javascript">
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0D',
        changeYear: true,
        changeMonth: true
    });
    function getStatistic() {
        var from = $('#from').val();
        var to = $('#to').val();
        var id = $('#id').val();
        var url = '{{ route("api.product.statistic") }}';
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {from: from, to: to, id: id},
            success: function (data) {
                $('#result').html(data);
                resume(from, to, id);
            },
            error: function (error) {
               $('#result').html(error);
            }
        });
    }

   function resume(){
            try{
                let _loading = `<div class="container text-center"><i class="fas fa-spinner fa-spin-pulse fa-spin-reverse "></i></div>`;
                let _content = document.querySelector("#resume");

                var url = '{{ route("product.resume.statistic", ["from"=>":from", "id"=> ":id", "to"=>":to"]) }}';
                url =  url.replace(":from", from.value);
                url =  url.replace(":to", to.value);
                url =  url.replace(":id", id.value);
                _content.innerHTML= _loading;
                fetch(url)
                    .then( resp => resp.json() )
                    .then( resp => {                    
                        // _content.innerHTML = resp;
                        _content.innerHTML = `<ul class="list-group">`;
                        resp.forEach((row) =>{
                            _content.innerHTML += `<li class="list-group-item"><b>${getMorphName(row.item_type)}</b>: ${row.qtd}</li>`
                        })
                        _content.innerHTML += `</ul>`;
                        // console.log(resp);
                });
            }catch(error){
                console.log(`Ocorreu um erro ao buscar resumo do produto: ${error}`); 
            }
        
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

</script>