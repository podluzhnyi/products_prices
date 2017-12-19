@extends('backLayout.app')
@section('title')
Edit Price
@stop

@section('content')

    <h1>Edit Price</h1>
    <hr/>

    {!! Form::model($price, [
        'method' => 'PATCH',
        'url' => ['admin/prices', $price->id],
        'class' => 'form-horizontal'
    ]) !!}


    {!! Form::hidden('product_id', null, ['class' => 'form-control', 'required' => 'required']) !!}

            <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                {!! Form::label('price', 'Price: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('price', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
                {!! Form::label('start_date', 'Start Date: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    <div class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                        {!! Form::input('datetime-local', 'start_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
                {!! Form::label('end_date', 'End Date: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    <div class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                        {!! Form::input('datetime-local', 'end_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection