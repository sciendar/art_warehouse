<label class="form-label mb-1" for="status">
    Статус
</label>
<select class="single-select" name="status" id="status" data-select2-id="status" tabindex="-1" aria-hidden="true">
    @foreach(\App\Enums\PaintingStatus::titles_list() as $status_id => $status_title)
        <option value="{{ $status_id }}" @if(($_GET['status'] ?? null) == $status_id || $loop->first) selected @endif>
            {{ $status_title }}
        </option>
    @endforeach
</select>
