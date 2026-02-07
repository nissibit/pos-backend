<div>
    <h2>Pagamento nr: {{$payment->nr ?? 'N/A'}}</h2>
    <iframe src="{{  route('payment.print_simple', ['id' => $payment->id]) }}" id="pdfFrame" width="100%" height="600px">
    </iframe>
</div>