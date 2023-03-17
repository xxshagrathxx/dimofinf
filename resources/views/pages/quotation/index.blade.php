@extends('layouts.main')
      @section('title')
          Quotation
      @endsection

      @section('styles')
        <style>
            .result{
            color:red;
            }
            td
            {
                text-align:center;
            }
            #new tr td {
                text-align: left
            }
            .validation {
                padding: 5px;
                color: #f00;
                font-size: 12px;
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
      @endsection

    @section('content')
        <h1>Quotation</h1>
        <span class="mt-4"> Time : </span><span  class="mt-4" id="time"></span>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ">
                <span id="day"></span> : <span id="year"></span>
            </div>
        </div>
        <section class="mt-3">
            {{-- <h4 style="color: #4d83ff"> Blu Restaurant & Hotel </h4> --}}
            {{-- <h6 class="text-center"> Shine Metro Mkadi Naka (New - Delhi)</h6> --}}
            <div class="card" style="margin: 20px 0;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="customer"><span style="font-weight: 500; color: #4d83ff; font-size: 15px">Customer</span></label>
                                <select name="customer" id="customer" class="form-control">
                                    <option value="" selected="" disabled="">Choose Customer</option>
                                    @foreach($customers as $customer)
                                        <option id={{$customer->id}} value={{$customer->name}} class="product custom-select">
                                            {{$customer->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="customerValidation" class="validation"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="currency"><span style="font-weight: 500; color: #4d83ff; font-size: 15px">Currency</span></label>
                                <select name="currency" id="currency" class="form-control">
                                    <option value="" selected="" disabled="">Choose Currency</option>
                                    @foreach($currencies as $currency)
                                        <option id={{$currency->id}} value={{$currency->symbol}} class="product custom-select">
                                            {{$currency->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="currencyValidation" class="validation"></div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button class="btn btn-success" style="display: flex" id="btnShow" onclick="showDiv()">Show Form</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="display: none" id="formDiv">
                <table class="table" style="background-color:#e0e0e0;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left; width: 3%">1</td>
                            <td>
                                <select name="product" id="product" class="form-control">
                                    <option value="val0" selected="" disabled="">Choose Product</option>
                                    @foreach($products as $product)
                                        <option id={{$product->id}} value={{$product->id}} class="product custom-select">
                                            {{$product->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width: 7%">
                                <input type="number" id="qty" min="0" value="0" class="form-control">
                            </td>
                            <td style="width: 3%">
                                <h5 class="mt-1" id="price"></h5>
                            </td>
                            <td><button id="add" class="btn btn-success">Add</button></td>
                        </tr>
                        <tr>
                        </tr>

                    </tbody>
                </table>
                <div role="alert" id="errorMsg" class="mt-5" >
                    <!-- Error msg  -->
                </div>
            </div>
            {{-- <a href="javascript:void(0);" class="btnPrint" id="btnPrint">Print</button> --}}
            <div class="card">
                <div id="quot_table_validation" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 20px; border-radius: 5px; display: none"></div>
                <div class="card-body" id="print-quote">
                    <h4 style="padding: 10px">Customer Name: <span id="customerNameReciept"></span></h4>
                    <div class="row">
                        <div class="p-4">
                            <div class="row">
                                </span>
                                <table id="receipt_bill" class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th colspan="2">Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="new">
                                    </tbody>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td class="text-right text-dark" style="padding-top: 50px">
                                                <h5><strong>Sub Total:  </strong></h5>
                                                <p><strong>Tax (5%) : </strong></p>
                                        </td>
                                        <td class="text-center text-dark" style="padding-top: 50px">
                                            <h5> <strong><span id="subTotal"></strong></h5>
                                            <h5> <strong><span id="taxAmount"></strong></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td class="text-right text-dark" style="padding-top: 50px">
                                            <h5><strong>Gross Total: </strong></h5>
                                        </td>
                                        <td class="text-center text-danger" style="padding-top: 50px">
                                            <h5 id="totalPayment"><strong> </strong></h5>

                                        </td>
                                    </tr>
                                </table>
                                <button id="save" class="btn btn-success">Save Quotation</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @section('scripts_bot')
            <script>
                function showDiv() {
                    var customerValidation = document.getElementById("customerValidation");
                    customerValidation.innerHTML = "";
                    var currencyValidation = document.getElementById("currencyValidation");
                    currencyValidation.innerHTML = "";

                    var customer = document.getElementById("customer");
                    var currency = document.getElementById("currency");

                    if(customer.selectedIndex <= 0) {
                        customerValidation.innerHTML = "Must select a customer first";
                        return;
                    }
                    customer.disabled = true;

                    if(currency.selectedIndex <= 0){
                        currencyValidation.innerHTML = "Must select a currency first";
                        return;
                    }
                    currency.disabled = true;

                    document.getElementById('formDiv').style.display = "block";
                }
            </script>
            <script>
                $(document).ready(function(){
                $('#product').change(function() {
                var ids =   $(this).find(':selected')[0].id;
                    $.ajax({
                    type:'GET',
                    url:'getPrice/{id}',
                    data:{id:ids},
                    dataType:'json',
                    success:function(data)
                        {

                            $.each(data, function(key, resp)
                            {
                                $('#price').text(resp.sale_price);
                            });
                        }
                    });
                });

                //add to cart
                var count = 1;
                $('#add').on('click',function(){
                    var name = $('#product').find(":selected").text();
                    var index = $('#product').get(0).selectedIndex;
                    $('#product option:eq(' + index + ')').remove();
                    $("#product").val("val0").change();

                    var productId = $('#product').val();
                    var customer = $('#customer').val();
                    var currencySymbol = $('#currency').val();
                    var qty = $('#qty').val();
                    var price = $('#price').text();

                    document.getElementById("customerNameReciept").innerHTML = customer;

                    if(qty == 0)
                    {
                        var erroMsg =  '<span class="alert alert-danger ml-5">Minimum Qty should be 1 or More than 1</span>';
                        $('#errorMsg').html(erroMsg).fadeOut(9000);
                    }
                    else
                    {
                        billFunction(); // Below Function passing here
                    }

                    function billFunction()
                    {
                    var total = 0;

                    $("#receipt_bill").each(function () {
                    var total =  price*qty;
                    var subTotal = 0;
                    subTotal += parseInt(total);

                    var table =   '<tr><td>'+ count +'</td><td style="display: none">' + productId + '</td><td colspan="2">'+ name + '</td><td>' + qty + '</td><td>' + price + '</td><td><strong><input type="hidden" id="total" value="'+total+'">' +total+ '</strong></td></tr>';
                    $('#new').append(table)

                        // Code for Sub Total of products
                        var total = 0;
                        $('tbody tr td:last-child').each(function() {
                            var value = parseInt($('#total', this).val());
                            if (!isNaN(value)) {
                                total += value;
                            }
                        });
                        $('#subTotal').text(total + " " + currencySymbol);

                        // Code for calculate tax of Subtoal 5% Tax Applied
                        var Tax = (total * 5) / 100;
                        $('#taxAmount').text(Tax.toFixed(2) + " " + currencySymbol);

                        // Code for Total Payment Amount

                        var Subtotal = $('#subTotal').text();
                        var taxAmount = $('#taxAmount').text();

                        var totalPayment = parseFloat(Subtotal) + parseFloat(taxAmount);
                        $('#totalPayment').text(totalPayment.toFixed(2) + " " + currencySymbol); // Showing using ID

                    });
                    count++;
                    }
                    });
                        // Code for year

                        var currentdate = new Date();
                        var datetime = currentdate.getDate() + "/"
                            + (currentdate.getMonth()+1)  + "/"
                            + currentdate.getFullYear();
                            $('#year').text(datetime);



                        // Code for extract Weekday
                            function myFunction()
                            {
                                var d = new Date();
                                var weekday = new Array(7);
                                weekday[0] = "Sunday";
                                weekday[1] = "Monday";
                                weekday[2] = "Tuesday";
                                weekday[3] = "Wednesday";
                                weekday[4] = "Thursday";
                                weekday[5] = "Friday";
                                weekday[6] = "Saturday";

                                var day = weekday[d.getDay()];
                                return day;
                                }
                            var day = myFunction();
                            $('#day').text(day);
                });
            </script>
            <script>
                window.onload = displayClock();

                function displayClock(){
                var time = new Date().toLocaleTimeString([], { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });
                // console.log(time);
                document.getElementById("time").innerHTML = time;
                    setTimeout(displayClock, 1000);
                }
            </script>
            {{-- <script>
                $(document).ready(function() {
                    $('#btnPrint').click(function(){
                        var printme = document.getElementById('print-quote');
                        var wme = window.open("");
                        wme.document.write(printme.innerHTML);
                        wme.document.close();
                        wme.focus();
                        wme.print();
                        wme.close();
                        // var mode = 'iframe';
                        // var close = mode == "popup";
                        // var options = { mode : mode, popClose : close};
                        // $("div.card-body").printArea( options );
                    });
                });
            </script> --}}
            <script>
                $('#save').click(function(){
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    let convertedIntoArray = [];

                    var customer = document.getElementById("customer").selectedIndex;
                    convertedIntoArray.push(customer);

                    var currency = document.getElementById("currency").selectedIndex;
                    convertedIntoArray.push(currency);

                    var quotVal = document.getElementById("quot_table_validation");
                    quotVal.style.display = "none";

                    var tableHtmlTbody = $('#new');

                    // $("tbody#new tr").each(function() {
                    if (!tableHtmlTbody.find('tr').length){
                        quotVal.style.display = "block";
                        quotVal.innerHTML = "Must create a valid Quotation first";
                        return;
                    }
                    else{
                        tableHtmlTbody.find('tr').each(function(){
                            let rowDataArray = [];

                            let actualData = $(this).find('td');
                            if (actualData.length > 0) {
                                actualData.each(function() {
                                    rowDataArray.push($(this).text());
                                });
                                convertedIntoArray.push(rowDataArray);
                            }
                        });
                    }

                    $(document).on('click','#save',function(e){
                        e.preventDefault();

                        Swal.fire({
                            title: 'Are you sure ?!!',
                            text: "Save This Data ?",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#71c016',
                            confirmButtonBorder: '#28a745',
                            cancelButtonColor: '#ff6363',
                            cancelButtonBorder: '#ff5959',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.post({
                                    type: "POST",
                                    // "_token": "{{ csrf_token() }}",
                                    url: '{{ route("quotation.store") }}',
                                    data:{_token: CSRF_TOKEN, 'table': convertedIntoArray},
                                    dataType: 'JSON',
                                    success: function (data) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Your work has been saved',
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then((result) => {
                                            window.location='{{route("quotation.list")}}'
                                        });
                                    },
                                    error: function (data) {
                                        console.log(data);
                                    }
                                });
                            }
                        })
                    });
                });
            </script>
        @endsection
    @endsection

