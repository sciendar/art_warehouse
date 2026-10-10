@php
    $columns = [
        '#',
        'Фото',
        'Позиція',
        'Назва'
    ];
@endphp

@include('admin._includes.add_images_modal')

<div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        @include('admin._layouts.table.thead', ['sort'=>'asc'])
        <tbody>
            @foreach($item->images as $this_item)
                @php
                    $position = $this_item->pivot->position;
                @endphp
                <tr>
                    <td class="align-content-center text-center" style="width: 75px">
                        {{ $position }}
                        <hr class="my-1">
{{--                        <a href="{{ route('admin.images.edit', $item) }}" class="text-primary" target="_blank">--}}
{{--                            <i class="bi bi-pencil-square"></i>--}}
{{--                        </a>--}}
                    </td>
                    <td class="align-content-center text-center" style="width: 150px">
                        <img src="{{ asset($this_item->get_i_image()) }}" width="150px" alt="">
                    </td>
                    <td class="align-content-center text-center" style="width: 75px">
                        <form action="{{ route($route . '.update', $item) }}" method="POST">
                            @method('PATCH')
                            @csrf

                            <div class="btn-group btn-group-sm">
                                <button type="submit" class="btn btn-sm btn-light {{ !$loop->first ? 'text-primary' : 'text-white' }}" name="image_up" {{ $loop->first ? 'disabled' : null }} data-bs-toggle="tooltip" title="Підняти">
                                    <i class="bi bi-caret-up"></i>
                                </button>
                                <input type="hidden" name="position" value="{{ $position }}">
                                <button type="button" class="btn btn-light" disabled>{{ $position }}</button>
                                <button type="submit" class="btn btn-light {{ !$loop->last ? 'text-primary' : 'text-white' }}" name="image_down" {{ $loop->last ? 'disabled' : null }} data-bs-toggle="tooltip" title="Опустити">
                                    <i class="bi bi-caret-down"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                    <td class="align-middle">
                        {{ $this_item->title }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        @include('admin._layouts.table.tfoot')
    </table>
</div>

@push('modals')

@endpush
