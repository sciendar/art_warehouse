@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    @include('admin._layouts._breadcrumbs')
@endsection

@section('content')
    @yield('breadcrumb')

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                @foreach($item->images as $image)
                    <div class="col-sm-2 text-center">
                        <a data-bs-toggle="modal" data-bs-target="#image_{{ $loop->index }}_modal">
                            <img src="{{ asset($image->path) }}" class="img-fluid" style="min-height: 250px; max-height: 250px; max-width: 250px">
                        </a>
                    </div>

                    <div class="modal fade" id="image_{{ $loop->index }}_modal" tabindex="-1" aria-labelledby="image_{{ $loop->index }}_modal" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="image_{{ $item->id }}_modal_label">{{ $item->id }} | {{ $item->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach($item->images as $image)
                                        @if($loop->index == $loop->parent->index)
                                            <img src="{{ asset($image->path) }}" class="img-fluid">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col mb-3">
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('code') !!}</dt>
                        <dd class="col-sm">{!! $item->code !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('title') !!}</dt>
                        <dd class="col-sm">{!! $item->title !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('description') !!}</dt>
                        <dd class="col-sm">{!! $item->description !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('condition') !!}</dt>
                        <dd class="col-sm">{!! $item->condition !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('note') !!}</dt>
                        <dd class="col-sm">{!! $item->note !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('track_number') !!}</dt>
                        <dd class="col-sm">{!! $item->track_number !!}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-auto text-truncate">{!! $model::alias('auction_id') !!} | {!! $model::alias('lot') !!}</dt>
                        <dd class="col-sm">
                            <a href="{{ $item->url }}" target="_blank">{!! $item->auction_id !!} | {!! $item->lot !!}</a>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
