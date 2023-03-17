@extends('layouts.main')

@section('title')
    {{ __('customers.list_title') }}
@endsection

@section('content')
        <table class="yajra-datatable table-striped" id="table">
            <thead>
                <tr>
                    <th>{{ __('customers.list_table_header_no') }}</th>
                    <th>{{ __('customers.list_table_header_name') }}</th>
                    <th>{{ __('customers.list_table_header_phone') }}</th>
                    <th>{{ __('customers.list_table_header_email') }}</th>
                    <th>{{ __('customers.list_table_header_Image') }}</th>
                    <th>{{ __('customers.list_table_header_updated_at') }}</th>
                    <th style="width: 15%">{{ __('customers.list_table_header_actions') }}</th>
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
            ajax: "{{ route('customer.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'image', name: 'image'},
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
