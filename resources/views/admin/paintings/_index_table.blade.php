<tr>
    <td class="text-center align-middle" style="width: 75px">
        {{ $loop->iteration }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
{{--        <span class="badge bg-{{ $item->status->color }}">--}}
{{--            {{ $item->status->title }}--}}
{{--        </span>--}}
{{--        <hr class="text-muted my-1">--}}
{{--        @include('admin._includes.tables.td_status')--}}
        <span class="badge bg-{{ $item->status?->color() }}">{{ $item->status?->title() }}</span>
        <hr class="text-muted my-1">
        @if(auth()->user()->is_manager())
            <a href="{{ route($route . '.show', $item) }}" data-bs-toggle="tooltip" title="Смотреть">
                <i class="bi bi-eye"></i>
            </a>
        @else
            <a href="{{ route($route . '.edit', $item) }}" data-bs-toggle="tooltip" title="Редактировать">
                <i class="bi bi-pencil-square"></i>
            </a>
        @endif
        <hr class="text-muted my-1">
        <span class="text-muted">#</span>
        {{ $item->id }}
    </td>
    <td class="text-center align-middle" style="width: 150px">
        @foreach($item->images as $image)
            @if($loop->first)
                <a data-bs-toggle="modal" data-bs-target="#image_{{ $item->id }}_table_modal">
                    <img src="{{ asset($image->path) }}" class="img-fluid" loading="lazy" decoding="async" style="min-height: 250px; max-height: 250px; max-width: 250px">
                </a>
            @endif
        @endforeach

        <div class="modal fade" id="image_{{ $item->id }}_table_modal" tabindex="-1" aria-labelledby="image_{{ $item->id }}_table_modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="image_{{ $item->id }}_table_modal_label">{{ $item->id }} | {{ $item->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_{{ $item->id }}_carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($item->images as $image)
                                    <div class="carousel-item text-center @if($loop->first) active @endif">
                                        <img src="{{ asset($image->path) }}" class="img-fluid" loading="lazy" decoding="async" style="min-height: 750px; max-height: 750px; max-width: 500px">
                                    </div>
                                @endforeach
                            </div>
                            @if($item->images->count() > 1)
                                <a class="carousel-control-prev" href="#modal_{{ $item->id }}_carousel" role="button" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#modal_{{ $item->id }}_carousel" role="button" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
    <td>
        {{ $item->code }}
        <br>
        {{ $item->title }}
        <hr class="my-1">
        {{ $item->description }}
    </td>
    <td>
        @if($item->warehouse_id != null)
            {!! $item->warehouse?->title !!}
            <br>
            {!! $item->warehouse?->country->title !!}, {!! $item->warehouse?->city ?? $NO_DATA !!}, {!! $item->warehouse?->address ?? $NO_DATA !!}
        @else
            <span class="text-danger">Добавлено админом</span>
        @endif
    </td>

    <td class="text-center align-middle" style="width: 100px">
	    {{ $item->created_at != null ? $item->created_at->format('Y.m.d') : '??' }}
        <br>
        {{ $item->created_at != null ? $item->created_at?->format('H:i:s') : '??' }}
    </td>
</tr>
