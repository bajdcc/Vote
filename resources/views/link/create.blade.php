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
            <form method="POST" action="{{ route('service.link.store') }}" accept-charset="UTF-8">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">

                <h2>Create New Link</h2>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" class="validate" value="{{ Request::old('name') }}">
                        <label for="name">Name</label>
                        {{ ($errors->has('name') ? $errors->first('name') : '') }}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="url" name="url" type="url" class="validate" value="{{ Request::old('url') }}">
                        <label for="url">Url</label>
                        {{ ($errors->has('url') ? $errors->first('url') : '') }}
                    </div>
                </div>

                <p>
                    <button class="btn waves-effect waves-light red" type="submit" name="action">Create
                        <i class="mdi-content-send right"></i>
                    </button>
                </p>

            </form>
        </div>
    </div>
@stop