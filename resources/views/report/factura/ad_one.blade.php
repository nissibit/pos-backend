<html>
    <head>
        <style>
            @page {
                /*margin: 100px 25px;*/
                font-family: 'arial';
                font-size: 14px;
                margin: 140px 25px 110px 25px;
            }

            header {
                position: absolute;
                top: -110px;
                left: 0px;
                right: 0px;
                width: 100%;
            }
            main{
                position: relative;
                top: 65px;
            }

        </style>
    </head>
    <body>
        <header>
            @include('report.head')
        </header><br />
        <main>
            @include('report.factura.items')
            <div style="text-align: center;">
                <strong>Assinatura e Carimbo</strong>
                <br /><br />_____________________<br />
                ({{ __('O responável')}})
            </div>
            @include('report.footer')
        </main>
       
    </body>
</html>