@extends('layouts.main')

@section('title')
    Posts List
@endsection

@section('content')
    <div class="row">
        <div class="col-12 pb-5">
            <a href="{{ route('post.create') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create a new post</a>
        </div>
    </div>

    
        <table class="yajra-datatable table-striped" id="table" style="white-space: unset">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="15%">Title</th>
                    <th width="40%">Description</th>
                    <th width="7%">Phone</th>
                    <th width="15%">Created By</th>
                    <th width="13%">Actions</th>
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
            ajax: "{{ route('post.view') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'phone', name: 'phone'},
                {data: 'user_id', name: 'user_id'},
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
