<div class="form-group">
    {{ Form::label($name, null, ['class' => 'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    </div>
</div>