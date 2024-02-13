<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>POS </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/bootstrap.min.css') }}">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
</head>
<body>
    <div class="invoice-16 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner-9" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="invoice">
                                        <h1>#<span>{{ $invoice->correlative }}</span></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-info">
                            <div class="row">
                                <div class="col-sm-6 mb-50">
                                    <div class="invoice-number">
                                        <h4 class="inv-title-1">Fecha de la factura:</h4>
                                        <p class="invo-addr-1">
                                            {{ $invoice->created_at }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end mb-50">
                                    <h4 class="inv-title-1">POS</h4>
                                    <p class="inv-from-1">pos@example.com</p>
                                    <p class="inv-from-2">Lima, Perú</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-50">
                                    <h4 class="inv-title-1">Cliente</h4>
                                    <p class="inv-from-1">{{ $invoice->customer }}</p>
                                    <p class="inv-from-1">{{ $invoice->customerPhone }}</p>
                                    <p class="inv-from-2">{{ $invoice->customerAddress }}</p>
                                </div>
                                <div class="col-sm-6 text-end mb-50">
                                    <h4 class="inv-title-1">Detalles</h4>
                                    <p class="inv-from-1">Pago total: ${{ $invoice->total }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="table-outer">
                                <table class="default-table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                       
                                        
                                        @foreach ($invoice->product as $item)
                                       
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>{{ $item['unit_price'] }}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong class="text-danger">Total</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong class="text-danger">${{ $invoice->total }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            Imprimir factura
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download">
                            Descargar factura
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/invoice/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/app.js') }}"></script>
</body>
</html>
