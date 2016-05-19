@extends('layouts.app')

@section('title', 'Jump')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Jump</div>
                    <div class="panel-body">
                        {!! Form::open(array('route' => 'service.jump.index', 'method' => 'get', 'class' => 'form-horizontal')) !!}
                        {{ Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => []]) }}
                        {{ Form::bsText('url') }}
                        {{ Form::bsText('script') }}
                        {{ Form::bsText('killjs') }}
                        {{ Form::bsText('nocache') }}
                        {{ Form::component('bsSubmit', 'components.form.submit', ['name', 'value' => null, 'attributes' => []]) }}
                        {{ Form::bsSubmit('Jump!') }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
