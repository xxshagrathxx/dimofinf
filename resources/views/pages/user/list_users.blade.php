@extends('layouts.main')

@section('title')
    {{ __('users.list_title') }}
@endsection

@section('content')
        <table class="yajra-datatable table-striped" id="table">
            <thead>
                <tr>
                    <th>{{ __('users.list_table_header_no') }}</th>
                    <th>{{ __('users.list_table_header_name') }}</th>
                    <th>{{ __('users.list_table_header_email') }}</th>
                    <th>{{ __('users.list_table_header_Image') }}</th>
                    <th>{{ __('users.list_table_header_updated_at') }}</th>
                    <th style="width: 15%">{{ __('users.list_table_header_actions') }}</th>
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
            ajax: "{{ route('user.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
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
