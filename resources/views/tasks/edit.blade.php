@extends('layouts.app_react')

@section('title', "")

@section('content')

<div class="panel panel-default">
    <br />
    <div class="panel-heading">
        {{ link_to_route('tasks.index', '戻る', null, ['class' => 'btn btn-outline-primary'] ) }}
       <br />
       <br />
       <h3>編集</h3>
    </div>
    <hr />
    <div class="panel-body">
        {!! Form::model($task, ['route' => ['tasks.update', $task["id"] ], 'method' => 'patch', 
        'class' => 'form-horizontal']) !!}
        <div class="form-group">
            {!! Form::label('title', 'title', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('title', $task["title"], [
                    'id' => 'task-title', 'class' => 'form-control'
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('content', 'content', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('content', $task["content"], [
                    'id' => 'task-content', 'class' => 'form-control'
                ]) !!}
            </div>
        </div>
        <hr />       
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                {!! Form::button('<i class="fa fa-save"></i> 保存', 
                ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
        <hr />
        <div class="form-group">
            <div class="col-sm-6">
                {{ Form::open(['route' => ['tasks.destroy', $task["id"] ], 'method' => 'delete']) }}
                {{ Form::hidden('id', $task["id"] ) }}
                {{ Form::submit('Delete', ['class' => 'btn btn-outline-danger btn-sm']) }}
                {{ Form::close() }}
            </div>
        </div>         
    </div>
    <hr />
    <br />
    <div class="panel-footer">
    </div>
</div>

@endsection
