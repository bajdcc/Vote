@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Index
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col l10 m10 s10">
            <h2>Links</h2>
        </div>
        <div class="col l2 m2 s2">
            <a class="btn-floating btn-large waves-effect waves-light red title-button"
               href="{{ route('service.link.create') }}"><i class="mdi-content-add"></i></a>
        </div>
    </div>

    <div class="row">
        <table class="hoverable responsive-table">
            <thead>
                <tr>
                    <th data-field="name">Name</th>
                    <th data-field="url"class="truncate">Url</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($links as $link)
                <tr>
                    <td>
                        {{ $link->name }}
                    </td>
                    <td>
                        {{ $link->url }}
                    </td>
                    <td>
                        <button type="button" onClick="location.href='{{ route('service.link.show', array($link->id)) }}'" class="btn-floating waves-effect waves-light red lighten-1"><i class="mdi-action-open-in-new"></i></button>
                        <button type="button" onClick="location.href='{{ route('service.link.edit', array($link->id)) }}'" class="btn-floating waves-effect waves-light red lighten-1"><i class="mdi-content-create"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        {!! $links->render() !!}
    </div>
@stop
