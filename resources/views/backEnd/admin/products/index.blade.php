@extends('backLayout.app')
@section('title')
Product
@stop

@section('content')

    <h1>Products <a href="{{ url('admin/products/create') }}" class="btn btn-primary pull-right btn-sm">Add New Product</a></h1>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped table-hover" id="tbladmin/products">
            <thead>
                <tr>
                    <th>ID</th><th>Title</th><th>Price</th><th>Body</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ url('admin/products', $item->id) }}">{{ $item->title }}</a></td><td>{{ $item->price }}</td><td>{{ $item->body }}</td>
                    <td>
                        <a href="{{ url('admin/products/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a> 
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/products', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                        <a href="{{ url('admin/prices/index/' . $item->id ) }}" class="btn btn-success btn-xs">List of prices</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#tbladmin/products').DataTable({
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
                },
            ],
            order: [[0, "asc"]],
        });
    });
</script>
@endsection