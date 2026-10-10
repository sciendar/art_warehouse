@php
    $is_super_admin = auth()->user()->is_super_admin();
@endphp

<label class="form-label" for="role_id">
    Роль
</label>
<select class="single-select" name="role_id" id="role_id" data-select2-id="role_id" tabindex="-1" aria-hidden="true" required>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::roles() as $role)
        @if($is_super_admin || (!$is_super_admin && $role->id > 2))
            <option value="{{ $role->id }}" @if((isset($item) && $item->hasRole($role->title) == $role->id) || (old('role_id') == $role->id)) selected @endif>{{ $role->title }}</option>
        @endif
    @endforeach
</select>
