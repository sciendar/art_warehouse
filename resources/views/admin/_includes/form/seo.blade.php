<div class="row my-3">
    <div class="col-12">
        <label for="seo_title" class="mb-1">
            <i class="flag-icon flag-icon-{{ $LANG }}"></i> SEO title {{ $LANG }}
        </label>
        <input class="form-control mb-3" type="text" name="seo_title" id="seo_title" placeholder="Введите данные" value="{{ $item->seo_title ?? old('seo_title') }}" required>
    </div>
    <div class="col-12">
        <label for="seo_description" class="mb-1">
            <i class="flag-icon flag-icon-{{ $LANG }}"></i> SEO description {{ $LANG }}
        </label>
        <input class="form-control mb-3" type="text" name="seo_description" id="seo_description" placeholder="Введите данные" value="{{ $item->seo_description ?? old('seo_description') }}" required>
    </div>
</div>
