<div class="card h-100">
    @foreach($item->images as $image)
        @if($loop->first)
            <a class="text-center" data-bs-toggle="modal" data-bs-target="#image_{{ $item->id }}_modal">
                <img src="{{ asset($image->path) }}" class="img-fluid" loading="lazy" decoding="async" style="min-height: 250px; max-height: 250px; max-width: 250px">
            </a>
        @endif
    @endforeach

    <div class="modal fade" id="image_{{ $item->id }}_modal" tabindex="-1" aria-labelledby="image_{{ $item->id }}_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="image_{{ $item->id }}_modal_label">{{ $item->id }} | {{ $item->title }}</h5>
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

    <div class="card-body">
        @php
            if (auth()->user()->is_manager()) {
                $full_route = $route . '.show';
                $tooltip_title = 'Смотреть';
            } else {
                $full_route = $route . '.edit';
                $tooltip_title = 'Редактировать';
            }
        @endphp
        <h6 class="card-title">
            <div class="row justify-content-between">
                <div class="col">
                    <a href="{{ route($full_route, $item) }}" data-bs-toggle="tooltip" title="{{ $tooltip_title }}">
                        {{ $item->code }}
                    </a>
                </div>
                <div class="col-auto">
                    <span class="badge bg-{{ $item->status?->color() }}">{{ $item->status?->title() }}</span>
                </div>
            </div>
        </h6>
        <hr class="my-1">
        <div class="row justify-content-between">
            <div class="col text-primary" data-bs-toggle="tooltip" title="Дата добавления">
                <span class="mx-1">
                    <i class="bi bi-plus-square"></i>
                </span>
                {{ $item->created_at?->format('Y.m.d H:i') ?? '--' }}
            </div>
            <div class="col text-primary" data-bs-toggle="tooltip" title="Дата отправки">
                <span class="mx-1">
                    <i class="bi bi-box2"></i>
                </span>
                {{ $item->tracking_at?->format('Y.m.d H:i') ?? '--' }}
            </div>
        </div>
        <hr class="my-1">
        @if($item->title != null)
            {{ $item->title }}
            <hr class="my-1">
        @endif
        @if($item->description != null)
            {{ $item->description }}
            <hr class="my-1">
        @endif
        @if($item->warehouse_id != null)
            {!! $item->warehouse?->title !!}
            <br>
            {!! $item->warehouse?->country->title !!}, {!! $item->warehouse?->city ?? $NO_DATA !!}, {!! $item->warehouse?->address ?? $NO_DATA !!}
        @else
            <span class="text-danger">Добавлено админом</span>
        @endif
    </div>
</div>
