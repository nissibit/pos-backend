<script>
    $(document).ready(function () {
        getData(0, 1, 'id', 1);
        $("#search, #othercode").autocomplete({
            source: "{{ route('product.autocomplete') }}",
            select: function (event, ui) {
                getData(ui.item.id, 99, 'id', 1);
                $('#search').val('');
                $('#search').focus();
                return false;
            }
        });
        
    });
    function getData(id, operation, searchBy, quantity) {
        var url = '{{ route("product.item.add") }}';
        if (parseFloat(quantity) <= 0 || parseInt(quantity) === undefined || quantity === '') {
            bootbox.alert('Informe a quantidade');
            return;
        }
        $.ajax({
            'type': 'GET',
            'url': url,
            data: {id: id, operation: operation, searchBy: searchBy, quantity: quantity, view: true},
            success: function (data) {
                $("#tabela-result").html(data);
            }
        });

    }
    function submitForm(btn) {
        btn.disabled = true;
        btn.form.submit();
    }
</script>