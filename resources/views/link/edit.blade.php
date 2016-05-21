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
            <form method="POST" action="{{ route('service.link.update', array('id' => $link->id)) }}"
                  accept-charset="UTF-8" role="form">
                <input name="_method" value="PUT" type="hidden">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">

                <h4>Link</h4>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" class="validate"
                               value="{{ $link->name }}">
                        <label for="name">Name</label>
                        {{ ($errors->has('name') ? $errors->first('name') : '') }}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="url" name="url" type="url" class="validate" value="{{ $link->url }}">
                        <label for="url">Url</label>
                        {{ ($errors->has('url') ? $errors->first('url') : '') }}
                    </div>
                </div>

                <p>
                    <button class="btn waves-effect waves-light red" type="submit" name="action">Save Changes
                        <i class="mdi-content-send right"></i>
                    </button>
                </p>

            </form>
        </div>
    <div>

@stop
