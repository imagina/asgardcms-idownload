<div class="box-body">
    <p>

        <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[title]", trans('idownload::categories.form.title')) !!}
            {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('idownload::categories.form.title')]) !!}
            {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[description]", trans('idownload::categories.form.description')) !!}
            {!! Form::textarea("{$lang}[description]", old("{$lang}.description"), ['class' => 'form-control', 'placeholder' => trans('iplaces::categories.form.description')]) !!}
            {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[slug]", trans('idownload::categories.form.slug')) !!}
            {!! Form::text("{$lang}[slug]", old("{$lang}.slug"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('idownload::categories.form.slug')]) !!}
            {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.meta_title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[meta_title]", trans('idownload::categories.form.meta_title')) !!}
            {!! Form::text("{$lang}[meta_title]", old("{$lang}.meta_title"), ['class' => 'form-control',  'placeholder' => trans('idownload::categories.form.meta_title')]) !!}
            {!! $errors->first("{$lang}.meta_title", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.meta_keywords") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[meta_keywords]", trans('idownload::categories.form.meta_keywords')) !!}
            {!! Form::text("{$lang}[meta_keywords]", old("{$lang}.meta_keywords"), ['class' => 'form-control',  'placeholder' => trans('idownload::categories.form.meta_keywords')]) !!}
            {!! $errors->first("{$lang}.meta_keywords", '<span class="help-block">:message</span>') !!}
        </div>

        @editor('meta_description', trans('idownload::categories.form.meta_description'),
        old("{$lang}.meta_description"), $lang)

    </p>
</div>
