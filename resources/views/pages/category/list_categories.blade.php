@extends('layouts.main')

@section('title')
    All Categories
@endsection

@section('content')
        <table class="yajra-datatable table-striped">
            <thead>
                <tr>
                    <th>{{ __('products.list_table_header_no') }}</th>
                    <th>{{ __('products.list_table_header_name') }}</th>
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
            ajax: "{{ route('category.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
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
