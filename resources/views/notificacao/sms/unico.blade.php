<div class="row">
    <div class="col-sm-5 well">
        <form action="{{ route('send.sms.unico') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="encaregado_id">
                    Encaregado <span class="required">*</span>
                </label>
                <select name="encaregado_id" id="encaregado_id" type="text" class="form-control selectpicker" required data-live-search="true" title="Seleccione o encaregado">
                    @foreach($encaregados as $encaregado)
                    <option value="{{ $encaregado->id }}" {{ old('encaregado_id', '') == $encaregado->id ? 'selected' : '' }}>{{ $encaregado->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="empresa_id">
                    Empresa
                </label>
                <select name="empresa_id" id="empresa_id" type="text" class="form-control" data-live-search="true" title="Seleccione a empresa">
                    <option value=""></option>
                    @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ old('empresa_id', '') == $encaregado->id ? 'selected' : '' }}>{{ $empresa->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Mensagem: </label>
                <textarea name="mensagem" class="form-control" rows="5" value="" id="mensagem"></textarea>
                <p>
                    <span id="restantes">160 caracteres restantes</span>
                    <span id="mensagems">1 mensagem(s)</span>
                </p>
            </div>
            <input type="hidden" value="0" name="tamanhoMensagem" id="tamanhoMensagem" />
            <label>
                <!--<input type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-play'></i> Play" data-off="<i class='fa fa-pause'></i> Pause">-->
            </label>
            <br />
            <button type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-send"> enviar</i>
            </button>
        </form>
    </div>
    <div class="col-sm-6 col-sm-offset-1" id="informacaoEncaregado">
        <div class="well">
            <p>Detalhes do encaregado e aluno</p>
        </div>

    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function(){ 
            var $restantes = $('#restantes'),
                    $mensagems = $restantes.next(),
                    $tamanho = $("#tamanhoMensagem"),
                    sel = document.getElementById("empresa_id"),
                    $empresa =  sel.options[sel.selectedIndex].text;
                    $('#mensagem').keyup(function () {
                        var chars = this.value.length + $empresa.length,
                                mensagems = Math.ceil(chars / 160),
                                restantes = mensagems * 160 - (chars % (mensagems * 160) || mensagems * 160);

                        $restantes.text(restantes + ' caracteres restantes');
                        $mensagems.text(mensagems + ' mensagem(s)');
                        $tamanho.val(mensagems);
                    });
        });

        $("#encaregado_id").on('change', function () {
            var id = this.value;
            var url = '{{ route("api.encaregado",":id") }}';
            url = url.replace(":id", id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $("#informacaoEncaregado").html(data);
                }
            });
        });
    </script>

</div>
<div class="clearfix"></div>