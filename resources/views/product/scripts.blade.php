
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        calMargem();
        $('#name').on('keyup', function (key) {
            $('#label').val(this.value.replace(/ /g, '_').toLowerCase());
        });
        var barcode = document.getElementById("generate_barcode").checked;
        if (barcode) {
            $('#barcode').val('');
            $('#barcode').css('display', 'none');
        }
        var othercode = document.getElementById("generate_othercode").checked;
        if (othercode) {
            $('#othercode').val('');
            $('#othercode').css('display', 'none');
        }

    });
    function findPrice() {
        var rate = $('#rate').val();
        var price = $('#buying').val();
        var margem = $('#margem').val();
        price = (price !== '' || price === undefined ? parseFloat(price) : 0);
        margem = (margem !== '' || margem === undefined ? parseFloat(margem) : 0);
        rate = (rate !== '' || rate === undefined ? parseFloat(rate) : 0);
        var total = ((price * margem) / 100) + price;
        $('#price').val(Math.round(total + (total * rate) / 100));

    }
    $('#generate_barcode').on('change', function () {
        var valor = this.checked;
        if (valor) {
            $('#barcode').val('');
            $('#barcode').css('display', 'none');
        } else {
            $('#barcode').val('');
            $('#barcode').css('display', 'block');
            $('#barcode').focus();
        }
    });
    $('#generate_othercode').on('change', function () {
        var valor = this.checked;
        if (valor) {
            $('#othercode').val('');
            $('#othercode').css('display', 'none');
        } else {
            $('#othercode').val('');
            $('#othercode').css('display', 'block');
            $('#othercode').focus();
        }
    });
    function calMargem() {
        var buying = $('#buying').val();
        var current = $('#price').val();
        buying = (buying !== '' || buying === undefined ? parseFloat(buying) : 0);
        current = (current !== '' || current === undefined ? parseFloat(current) : 0);
        if (buying !== 0 && current !== 0) {
            var margem = ((current - buying) / buying) * 100;
            $('#margem').val(Math.round(margem));
        } else {
            $('#margem').val(0);
        }
    }
</script>
