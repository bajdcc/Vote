@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Show
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col l10 m10 s10">
            <h2>Link Details</h2>
        </div>
        <div class="col l2 m2 s2">
            <a class="btn-floating btn-large waves-effect waves-light red title-button"
               href="{{ route('service.link.edit', array('id' => $link->id)) }}"><i class="mdi-content-create"></i></a>
            <a class="btn-floating btn-large waves-effect waves-light red title-button"
               href="{{ route('service.link.index') }}"><i class="mdi-action-home"></i></a>
        </div>
    </div>

    <div class="row">
        <div class="col m8 s12">
            <h4>Details</h4>

            <div class="divider"></div>
            <br/>
            <div class="row">
                <div class="col s2">
                    <strong>Name</strong>
                </div>
                <div class="col s10">
                    <em>{{ str_limit($link->name, 60) }}</em>
                </div>
            </div>
            <div class="row">
                <div class="col s2">
                    <strong>Url</strong>
                </div>
                <div class="col s10">
                    <em>{{ link_to($link->url, str_limit($link->url, 60), array('target' => '_blank')) }}</em>
                </div>
            </div>
            <div class="row">
                <div class="col s8">
                    <p>
                        <em>Link created: {{ $link->created_at }}</em>
                        <br/>
                        <em>Last Updated: {{ $link->updated_at }}</em>
                    </p>
                </div>
                <div class="col s4">
                    <br/>
                    <form method="POST" action="{{ route('service.link.destroy', array('id' => $link->id)) }}"
                          accept-charset="UTF-8" role="form">
                        <input name="_method" value="DELETE" type="hidden">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <button type="submit" class="btn waves-effect waves-light red lighten-1 action_confirm">
                            <i class="mdi-action-delete left"></i>DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
