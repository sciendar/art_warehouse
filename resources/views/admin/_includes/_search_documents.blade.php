@php
    $data = 'documents';
@endphp

<div class="row">
    @foreach($documents as $document)
        <div class="col-12 mb-3 text-truncate">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="document_{{ $data }}_{{ $document->id }}" name="document_ids[]" data-id="document_{{ $data }}_{{ $document->id }}" value="{{ $document->id }}" @if($item->documents->contains($document->id)) checked disabled @endif>
                <label class="form-check-label mx-3" for="document_{{ $data }}_{{ $document->id }}" data-id="document_{{ $data }}_{{ $document->id }}">
                    <p class="my-0" data-bs-toggle="tooltip" title="{{ $document->title_uk }}">{{ Number::fileSize($document->size ?? 0, 2) }} | {{ Str::limit($document->title_uk, 50, '...') }}</p>
                </label>
            </div>
        </div>
    @endforeach
</div>
