<div class="row">
    <div class="input-field col s12">
        {{ Form::text($name, $value, array_merge(['class' => 'validate'], $attributes)) }}
        {{ Form::label($name) }}
        {{ ($errors->has('name') ? $errors->first('name') : '') }}
    </div>
</div>