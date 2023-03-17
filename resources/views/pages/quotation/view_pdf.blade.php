<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            body{
                margin-top:20px;
                color: #484b51;
            }
            .text-secondary-d1 {
                color: #728299!important;
            }
            .page-header {
                margin: 0 0 1rem;
                padding-bottom: 1rem;
                padding-top: .5rem;
                border-bottom: 1px dotted #e2e2e2;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-pack: justify;
                justify-content: space-between;
                -ms-flex-align: center;
                align-items: center;
            }
            .page-title {
                padding: 0;
                margin: 0;
                font-size: 1.75rem;
                font-weight: 300;
            }
            .brc-default-l1 {
                border-color: #dce9f0!important;
            }

            .ml-n1, .mx-n1 {
                margin-left: -.25rem!important;
            }
            .mr-n1, .mx-n1 {
                margin-right: -.25rem!important;
            }
            .mb-4, .my-4 {
                margin-bottom: 1.5rem!important;
            }

            hr {
                margin-top: 1rem;
                margin-bottom: 1rem;
                border: 0;
                border-top: 1px solid rgba(0,0,0,.1);
            }

            .text-grey-m2 {
                color: #888a8d!important;
            }

            .text-success-m2 {
                color: #86bd68!important;
            }

            .font-bolder, .text-600 {
                font-weight: 600!important;
            }

            .text-110 {
                font-size: 110%!important;
            }
            .text-blue {
                color: #478fcc!important;
            }
            .pb-25, .py-25 {
                padding-bottom: .75rem!important;
            }

            .pt-25, .py-25 {
                padding-top: .75rem!important;
            }
            .bgc-default-tp1 {
                background-color: rgba(121,169,197,.92)!important;
            }
            .bgc-default-l4, .bgc-h-default-l4:hover {
                background-color: #f3f8fa!important;
            }
            .page-header .page-tools {
                -ms-flex-item-align: end;
                align-self: flex-end;
            }

            .btn-light {
                color: #757984;
                background-color: #f5f6f9;
                border-color: #dddfe4;
            }
            .w-2 {
                width: 1rem;
            }

            .text-120 {
                font-size: 120%!important;
            }
            .text-primary-m1 {
                color: #4087d4!important;
            }

            .text-danger-m1 {
                color: #dd4949!important;
            }
            .text-blue-m2 {
                color: #68a3d5!important;
            }
            .text-150 {
                font-size: 150%!important;
            }
            .text-60 {
                font-size: 60%!important;
            }
            .text-grey-m1 {
                color: #7b7d81!important;
            }
            .align-bottom {
                vertical-align: bottom!important;
            }
            table{
                max-width: 750px;
            }
        </style>
    </head>
    <body>
        <div>
            <div>
                <h1>
                    Quotation
                    <small>
                        REF: #{{ $quotation->quotation_ref_no }}
                    </small>
                </h1>
            </div>

            <div>
                <div>
                    <div>
                            <hr>
                            <table style="padding: 10px">
                                <tr style="width: 100%">
                                    <td style="width: 300px">
                                        <div>
                                            <div>
                                                <span>To:</span>
                                                <span>{{ $quotation->customer->name }}</span>
                                            </div>
                                            <div>
                                                <div>Phone: <b class="text-600">{{ $quotation->customer->phone }}</b></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                <div>
                                                    Quotation
                                                </div>

                                                <div><span class="text-600 text-90">Issue Date: </span>{{ Carbon\Carbon::parse($quotation->created_at)->format('D d M Y') }}</div>

                                                <div class="my-2">
                                                    <span class="text-600 text-90">Status:</span>
                                                    {!! $quotation->status == 'Pending' ? '<span style="font-weight: 900;color: #fff;background-color: #ffc107;border-radius: 10rem;padding: 3px">'.$quotation->status.'</span>' : '<span style="font-weight: 900;color: #fff;background-color: #28a745;border-radius: 10rem;padding: 3px">'.$quotation->status.'</span>' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                                <table style="width: 100%">
                                    <tr>
                                        <th style="width: 40px">#</th>
                                        <th style="width: 270px">Product Name</th>
                                        <th style="width: 70px">Qty</th>
                                        <th style="width: 120px">Unit Price</th>
                                        <th style="width: 120px">Amount</th>
                                    </tr>
                                    @php
                                        $subTotal = 0;
                                        $sno = 0;
                                    @endphp
                                    @foreach ($resultArr as $itemArr)
                                        <tr>
                                            @php
                                                $itemArr = explode(" ", $itemArr);
                                                $productName = $itemArr[0];
                                                $qty = $itemArr[1];
                                                $price = $itemArr[2];
                                                $amount = $qty * $price;
                                                $subTotal += $amount;
                                            @endphp
                                            <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ ++$sno }}</td>
                                            <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ $productName }}</td>
                                            <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ $qty }}</td>
                                            <td style="border:1px solid #000; text-align: center;padding: 4px;">${{ $price }}</td>
                                            <td style="border:1px solid #000; text-align: center;padding: 4px;">${{ $amount }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <hr>
                                <table style="float: right">
                                    <tr>
                                        <td>SubTotal: </td>
                                        <td><b>${{ $subTotal }}</b></td>
                                    </tr>
                                    <tr>
                                        @php
                                            $DBtax = $quotation->tax;
                                            $tax = ($subTotal * $DBtax) / 100;
                                            $total = $subTotal + $tax;
                                        @endphp
                                        <td>Tax ({{ $DBtax }}%): </td>
                                        <td><b>${{ $tax }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount: </td>
                                        <td><b>${{ $total }}</b></td>
                                    </tr>
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
