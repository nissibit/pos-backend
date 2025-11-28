@extends("payment.indexPayment")
@section("content-payment")
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
                @include('payment.info')
            </div>
            <div class="col" id="print">
                <iframe src="{{  route('payment.print_simple', ['id' => $payment->id]) }}" width="100%" height="600px">
                        </iframe>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
       //  let _element = $("#print");
       //  var url = "{{ route('payment.print') }}";
       //  var overlayLoading = '<div class="overlay-wrapper text-center"><div class="overlay"><i class="fas fa-3x fa-spinner fa-spin"></i><div class="text-bold pt-2"> Carregando... </div></div></div>';
       // callPDF();
       //  function callPDF() {
       //      $.ajax({
       //          url: url,
       //          method: "GET",
       //          data: {id: '{{ $payment->id }}'},
       //          success: function (data) {
       //              _element.empty().html('<iframe src="{{URL::to("/")}}/reports/' + data + '.pdf" width="100%" height="700px"></iframe>');
       //          },
       //          beforeSend: function () {
       //              _element.empty().html(overlayLoading);
       //          }
       //      });
       //  }

    }
    );
</script>
@endsection
