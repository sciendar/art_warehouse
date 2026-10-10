@isset($categories)
    <option value="" selected>Сделайте выбор</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(isset($item) && $item->category_id == $category->id)>{{ $category->title }}</option>
    @endforeach
@endisset
