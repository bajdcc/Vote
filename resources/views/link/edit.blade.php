@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Edit
@stop

{{-- Content --}}
@section('content')

    <div class="row">
        <div class="col l10 m10 s10">
            <h3>Update Link</h3>
        </div>
        <div class="col l2 m2 s2">
            <a class="btn-floating btn-large waves-effect waves-light red title-button"
               href="{{ route('service.link.index') }}"><i class="mdi-action-home"></i></a>
        </div>
    </div>
    <div class="divider"></div>

    <div class="row">
        <div class="col l6 offset-l3 m8 offset-m2 s12">
            {!! Form::open(array('route' => array('service.link.update', 'id' => $link->id),
             'method' => 'post', 'class' => 'form-horizontal', 'accept-charset' => 'UTF-8')) !!}
            {!! Form::Token() !!}
            <h4>Link</h4>
            {{ Form::component('mText', 'components.materials-form.text', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mText('name', $link->name) }}
            {{ Form::component('mUrl', 'components.materials-form.url', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mUrl('url', $link->url) }}
            {{ Form::component('mSubmit', 'components.materials-form.submit', ['name', 'value' => null, 'attributes' => []]) }}
            {{ Form::mSubmit('Save Changes') }}
            {!! Form::close() !!}
        </div>
    </div>

@stop
