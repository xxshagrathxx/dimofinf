@extends('layouts.main')

@section('title')
    {{ __('products.list_title') }}
@endsection

@section('content')
        <table class="yajra-datatable table-striped">
            <thead>
                <tr>
                    <th>{{ __('currencies.list_table_header_no') }}</th>
                    <th>{{ __('currencies.list_table_header_name') }}</th>
                    <th>{{ __('currencies.list_table_header_symbol') }}</th>
                    <th>{{ __('currencies.list_table_header_code') }}</th>
                    <th>{{ __('currencies.list_table_header_conversion') }}</th>
                    <th>{{ __('currencies.list_table_header_primary') }}</th>
                    {{-- <th style="width: 15%">{{ __('products.list_table_header_actions') }}</th> --}}
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
            ajax: "{{ route('currency.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'symbol', name: 'symbol'},
                {data: 'code', name: 'code'},
                {data: 'conversion', name: 'conversion'},
                {data: 'primary', name: 'primary'},
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: true,
                //     searchable: true
                // },
            ]
        });

    });
    </script>
@endsection
