<label for="{{ $data }}">
    {{ $label ?? Str::title($data) }}
    @if(isset($is_like) && $is_like === true)
        <span class="text-primary x-3" data-tooltip="tooltip" title="imprecise matches">
            <i class="fas fa-search"></i>
        </span>
    @endif
</label>
<input type="{{ $type ?? 'text' }}" name="{{ $data }}" class="form-control" id="{{ $data }}" value="{{ $_GET[$data] ?? null }}">
