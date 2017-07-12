@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">{{$action == 'create'?'新建项目':'编辑项目'}}</h4>
            </div>
            <div class="panel-body">
                @include('errors.form_erros')
                @if($action == 'create')
                <form action="{{url('/collection/create')}}" method="POST">
                    @else
                        <form action="{{url('/collection/update/'.$collection->id)}}" method="POST">
                    @endif
                    <div class="form-group">
                        <label for="collection-name">项目名称</label>
                        <input name="name" type="text" class="form-control" id="collection-name" value="{{isset($collection)?$collection->title:null}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">项目说明</label>
                        <textarea class="form-control" name="description" style="max-width: 100%">{{isset($collection)?$collection->description:null}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">提交</button>
                </form>
            </div>
        </div>
    </div>
@endsection