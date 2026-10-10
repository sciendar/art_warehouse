@php
    $data = 'image';
@endphp

<div class="row">
    @foreach($images as $image)
        <div class="col-sm-3 mb-3 text-truncate custom-control custom-radio">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="image_{{ $data }}_{{ $image->id }}" name="image_ids[]" data-id="image_{{ $data }}_{{ $image->id }}" value="{{ $image->id }}" @if($item->images->contains($image->id)) checked disabled @endif>
                <label class="form-check-label mx-3" for="image_{{ $data }}_{{ $image->id }}" data-id="image_{{ $data }}_{{ $image->id }}">
                    <p class="my-0" data-bs-toggle="tooltip" title="{{ $image->title_uk }}.{{ $image->extension }}">{{ Str::limit($image->title_uk, 50, '...') }}.{{ $image->extension }}</p>
                    <img class="img-fluid mb-2 w-100 h-auto" src="{{ asset($image->get_i_image()) }}" style="max-width: 100px">
                </label>
            </div>
        </div>
    @endforeach
</div>
