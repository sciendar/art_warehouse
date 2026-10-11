<label class="form-label" for="status">
    Статус
</label>
<select class="single-select" name="status" id="status" data-select2-id="status" tabindex="-1" aria-hidden="true" required>
    @foreach(\App\Enums\PaintingStatus::titles_list() as $status_id => $status_title)
        <option value="{{ $status_id }}" @if((isset($item) && $item->status->value == $status_id) || (old('status') == $status_id) || $loop->first) selected @endif>{{ $status_title }}</option>
    @endforeach
</select>
