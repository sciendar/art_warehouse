@php
    $warehouses = \App\Models\Warehouse::with('country','users')
        ->orderBy('title')
        ->get();
@endphp

<label class="form-label" for="warehouse_user_id">
    Склад
</label>
<select class="single-select" name="warehouse_user_id" id="warehouse_user_id" data-select2-id="warehouse_user_id" tabindex="-1" aria-hidden="true" @required($required ?? false) @disabled($disabled ?? false) @readonly($readonly ?? false)>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach($warehouses as $warehouse)
        @foreach($warehouse->users->sortBy('name') as $user)
            @if(auth()->user()->is_admin() || auth()->user()->is_manager() || auth()->id() == $user->id)
                <option value="{{ $warehouse->id }}_{{ $user->id }}" @selected((isset($item) && $item->warehouse_id == $warehouse->id && $item->user_id == $user->id) || (old('warehouse_user_id') == $warehouse->id . '_' . $user->id))>{{ $warehouse->title }} ({{ $warehouse->country?->title }}) | {{ $user->name }}</option>
            @endif
        @endforeach
    @endforeach
</select>
