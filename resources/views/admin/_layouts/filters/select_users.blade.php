<label class="form-label mb-1" for="user_id">
    Кладовщик
</label>
<select class="single-select" name="user_id" id="user_id" data-select2-id="user_id" tabindex="-1" aria-hidden="true" @required($required ?? false)>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::users() as $user)
        <option value="{{ $user->id }}" @if($user->id == ($_GET['user_id'] ?? null)) selected @endif>{{ $user->name }} ({{ $user->email }})</option>
    @endforeach
</select>
