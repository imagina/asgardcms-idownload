<div class="box-body">
    <p>
    <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('idownload::downloads.form.title')) !!}
        <?php $old = $download->hasTranslation($lang) ? $download->translate($lang)->title : '' ?>
        {!! Form::text("{$lang}[title]", old("{$lang}.title",$old), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('idownload::downloads.form.title')]) !!}
        {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[slug]", trans('idownload::downloads.form.slug')) !!}
        <?php $old = $download->hasTranslation($lang) ? $download->translate($lang)->slug : '' ?>
        {!! Form::text("{$lang}[slug]", old("{$lang}.slug",$old), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('idownload::downloads.form.slug')]) !!}
        {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
    </div>
    <?php $old = $download->hasTranslation($lang) ? $download->translate($lang)->description : '' ?>
    <div class='form-group{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
        @editor('description', trans('idownload::downloads.form.description'), old("$lang.description", $old), $lang)
    </div>
    </p>
</div>
