@extends('layouts.main')

@section('title')
    {{ __('products.list_title') }}
@endsection

@section('content')
        <table class="yajra-datatable table-striped" id="table">
            <thead>
                <tr>
                    <th>{{ __('products.list_table_header_no') }}</th>
                    <th>{{ __('products.list_table_header_refrence_no') }}</th>
                    <th>{{ __('products.list_table_header_name') }}</th>
                    <th>{{ __('products.list_table_header_category') }}</th>
                    <th>{{ __('products.list_table_header_Image') }}</th>
                    <th>{{ __('products.list_table_header_cost_price') }}</th>
                    <th>{{ __('products.list_table_header_sale_price') }}</th>
                    <th>{{ __('products.list_table_header_updated_at') }}</th>
                    <th style="width: 15%">{{ __('products.list_table_header_actions') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    <script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'refrence_no', name: 'refrence_no'},
                {data: 'name', name: 'name'},
                {data: 'category_id', name: 'category_id'},
                {data: 'image', name: 'image'},
                {data: 'cost_price', name: 'cost_price'},
                {data: 'sale_price', name: 'sale_price'},
                {data: 'updated_at', name: 'updated_at'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
    });
    </script>
@endsection
