
function notify(type, msg, title){
    toastr[type] (msg, title, {
                            "progressBar": true,
                            "timeOut": "5000",
                            "positionClass":"toast-top-full-width",
                            "preventDuplicates": true
                          });
}

function strErrors(erros){
    var msg = "";
    for (var key in erros) {
        // skip loop if the property is from prototype
        if (!erros.hasOwnProperty(key)) continue;
     
        var obj = erros[key];
        for (var prop in obj) {
            // skip loop if the property is from prototype
            if(!obj.hasOwnProperty(prop)) continue;
            msg += "<li> "+obj[prop]+"</li>";
        }
    }
    return msg;
}
document.addEventListener('DOMContentLoaded', function() {
   // $('body').confirmation({
   //      selector: '[data-toggle="confirmation"]',
   //      placement:'top',
   //      btnOkLabel: 'sim',
   //      btnCancelLabel: 'não'
   //  });
    
});

 
 $(document).ready(function() {
        //$('[data-toggle="popover"]').popover(); 
        $('.popover').popover(); 
        var table = $('#example').DataTable( {
            dom: 
                "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [                
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fas fa-file-excel text-success"> excel</i>',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }, 
                    footer: true
                },
                {
                    extend:    'csvHtml5',
                    text:      '<i class="fas fa-file-alt text-info"> csv</i>',
                    titleAttr: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }, 
                    footer: true
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="fas fa-file-pdf text-danger"> pdf</i>',
                    titleAttr: 'PDF',
                    title: 'Sistemade Gestao',
                    message: 'Relatório',
                    exportOptions: {
                        columns: ':visible'
                    }, 
                    footer: true,
                },
                {
                    extend:    'print',
                    text:      '<i class="fas fa-print"> print</i>',
                    titleAttr: 'PRINT',
                    exportOptions: {
                        columns: ':visible'
                    }, 
                    footer: true
                },
                {
                    extend:    'colvis',
                    text:      '<i class="fas fa-eye"> Colunas</i>',
                    titleAttr: 'Colunas Visiveis'                    
                }
            ],
            "olanguage": {
                "surl": "DataTables/Portuguese.json"
            }
        } );
        /* Filtrando por colunas */
         // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
 
    } );
    
 function confirmacao(){

        bootbox.confirm({
            message: "Tem certeza que pretende continuar?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                }
            },
        callback: function (result) {
            return result;
            
        }
    });
 }
 
 $(function(){
    $('[rel="popover"]').popover({
        container: 'body',
        html: true,
        content: function () {
            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
            return clone;
        }
    }).click(function(e) {
        e.preventDefault();
    });
});