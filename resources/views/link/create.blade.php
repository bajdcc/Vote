@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Create
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col l6 offset-l3 m8 offset-m2 s12">
            {!! Form::open(array('route' => 'service.link.store', 'method' => 'post', 'accept-charset' => 'UTF-8')) !!}
            {!! Form::Token() !!}
            <h2>Create New Link</h2>
            {{ Form::component('mText', 'components.materials-form.text', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mText('name', Request::old('name')) }}
            {{ Form::component('mUrl', 'components.materials-form.url', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mUrl('url', Request::old('url')) }}
            {{ Form::component('mSubmit', 'components.materials-form.submit', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mSubmit('Create') }}
            {!! Form::close() !!}
        </div>
    </div>
@stop