<div class="box-body">
    <p>
        <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[title]", trans('idownload::categories.form.title')) !!}
            <?php $old = $category->hasTranslation($lang) ? $category->translate($lang)->title : '' ?>
            {!! Form::text("{$lang}[title]", old("{$lang}.title",$old), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('idownload::categories.form.title')]) !!}
            {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[description]", trans('idownload::categories.form.description')) !!}
            <?php $old = $category->hasTranslation($lang) ? $category->translate($lang)->description : '' ?>
            {!! Form::textarea("{$lang}[description]", old("{$lang}.description",$old), ['class' => 'form-control', 'placeholder' => trans('iplaces::categories.form.description')]) !!}
            {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[slug]", trans('idownload::categories.form.slug')) !!}
            <?php $old = $category->hasTranslation($lang) ? $category->translate($lang)->slug : '' ?>
            {!! Form::text("{$lang}[slug]", old("{$lang}.slug", $old), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('idownload::categories.form.slug')]) !!}
            {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.metatitle") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[metatitle]", trans('idownload::categories.form.meta_title')) !!}
            {!! Form::text("{$lang}[metatitle]", old("{$lang}.metatitle"), ['class' => 'form-control',  'placeholder' => trans('idownload::categories.form.meta_title')]) !!}
            {!! $errors->first("{$lang}.metatitle", '<span class="help-block">:message</span>') !!}
        </div>

        <div class='form-group{{ $errors->has("{$lang}.metakeywords") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[metakeywords]", trans('idownload::categories.form.meta_keywords')) !!}
            {!! Form::text("{$lang}[metakeywords]", old("{$lang}.metakeywords"), ['class' => 'form-control',  'placeholder' => trans('idownload::categories.form.meta_keywords')]) !!}
            {!! $errors->first("{$lang}.metakeywords", '<span class="help-block">:message</span>') !!}
        </div>

        @editor('metadescription', trans('idownload::categories.form.meta_description'),
        old("{$lang}.metadescription"), $lang)
    </p>
</div>
