@extends('layouts.main')

@section('title')
    {{ __('quotations.list_title') }}
@endsection

@section('content')
        <table class="yajra-datatable table-striped" id="table">
            <thead>
                <tr>
                    <th>{{ __('quotations.list_table_header_no') }}</th>
                    <th>{{ __('quotations.list_table_header_quotation_ref_no') }}</th>
                    <th>{{ __('quotations.list_table_header_customer') }}</th>
                    <th>{{ __('quotations.list_table_header_currency') }}</th>
                    <th>{{ __('quotations.list_table_header_status') }}</th>
                    <th>{{ __('quotations.list_table_header_created_by') }}</th>
                    <th>{{ __('quotations.list_table_header_updated_at') }}</th>
                    <th style="width: 15%">{{ __('quotations.list_table_header_actions') }}</th>
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
            ajax: "{{ route('quotation.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'quotation_ref_no', name: 'quotation_ref_no'},
                {data: 'customer_id', name: 'customer_id'},
                {data: 'currency_id', name: 'currency_id'},
                {data: 'status', name: 'status'},
                {data: 'created_by', name: 'created_by'},
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
