<hr>
<div class="row">
    <div class="col-md mb-3">
        @include('admin._layouts.forms.input', ['data' => 'seo_title','label'=>$model::alias('seo_title'),'flag'=>'gb'])
    </div>
</div>

<div class="row">
    <div class="col-md mb-3">
        @include('admin._layouts.forms.input', ['data' => 'seo_keywords','label'=>$model::alias('seo_keywords'),'flag'=>'gb'])
    </div>
</div>

<div class="row">
    <div class="col-md mb-3">
        @include('admin._layouts.forms.input', ['data' => 'seo_description','label'=>$model::alias('seo_description'),'flag'=>'gb'])
    </div>
</div>
