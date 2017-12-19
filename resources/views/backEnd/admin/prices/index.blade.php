@extends('backLayout.app')
@section('title')
List of prices ({{$product->title}})
@stop

@section('content')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Äíè', 'With a shorter period', 'Installed later'],
                {!! $chart_data !!}
            ]);

            var options = {
                title: 'Product prices',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('prices_chart'));

            chart.draw(data, options);
        }
    </script>
    <div id="prices_chart" style="width: 100%; height: 500px"></div>


    <h1>List of prices ({{$product->title}}) <a href="{{ url('admin/prices/create') }}" class="btn btn-primary pull-right btn-sm">Add New Price</a></h1>
    <div class="table table-responsive">
        {!! Form::open([
            'method'=>'POST',
            'url' => ['admin/prices/index', $product->id],
            'style' => 'display:inline'
            ]) !!}
        {{csrf_field()}}
        <div class="form-group">
        <table class="table">
            <tr>
                <td><h5>Filter:</h5></td>
                <td>
                    <div class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                    {!! Form::input('datetime-local', 'start_date', null, ['class' => 'form-control', 'placeholder'=>'Y-m-d', 'required' => 'required', 'readonly']) !!}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </td>
                <td><div class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                    {!! Form::input('datetime-local', 'end_date', null, ['class' => 'form-control', 'placeholder'=>'Y-m-d', 'required' => 'required', 'readonly']) !!}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </td>
                <td>{!! Form::submit('Show result', ['class' => 'btn btn-success btn-sm', 'style'=>'padding:10px']) !!}</td>
            </tr>
        </table>
        </div>
        {!! Form::close() !!}
        <table class="table table-bordered table-striped table-hover" id="tbladmin/prices">
            <thead>
                <tr>
                    <th>ID</th><th>Price</th><th>Start Date</th><th>End Date</th><th>Updated</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($prices as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->price }}</td><td>{{ $item->start_date }}</td><td>{{ $item->end_date }}</td><td>{{ $item->updated_at }}</td>
                    <td>
                        <a href="{{ url('admin/prices/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/prices', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
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
        $('#tbladmin/prices').DataTable({
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