<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('idownload::downloads.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('idownload::downloads.form.title')]) !!}
        {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[slug]", trans('idownload::downloads.form.slug')) !!}
        {!! Form::text("{$lang}[slug]", old("{$lang}.slug"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('idownload::downloads.form.slug')]) !!}
        {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[description]", trans('idownload::downloads.form.description')) !!}
        {!! Form::textarea("{$lang}[description]", old("{$lang}.description"), ['class' => 'form-control', 'placeholder' => trans('idownload::downloads.form.description')]) !!}
        {!! $errors->first("{$lang}.description", '<span class="help-block">:message</span>') !!}
    </div>
</div>
