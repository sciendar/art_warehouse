@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs')
    </div>
    <hr/>
@endsection

@section('content')
    @yield('breadcrumb')
    <div class="card">
        <form action="{{ route('admin.messages.update', $item) }}" class="was-validated" id="send_message" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-header py-3">
                {{ $item->name }} {{ $item->email }}
                @if($item->user_id != null)
                    <span class="mx-3">
                    (
                    <a href="{{ route('admin.users.show', $item->user) }}" target="_blank">
                        {{ $item->user->first_name }} {{ $item->user->last_name }}
                    </a>
                    )
                </span>
                @endif
            </div>
            <div class="card-body">
                <div class="chat-content">

                    {{--                <div class="ps__rail-x" style="left: 0px; bottom: -628px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 628px; height: 520px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 285px; height: 235px;"></div></div></div>--}}
                    @forelse($items as $item)
                        @php
                            $old_date = $old_date ?? null;
                            $this_date = $item->created_at?->format('d.m.Y');
                            $old_time = $old_time ?? null;
                            $this_time = $item->created_at->format('H:i');
                        @endphp
                        @if($old_date != $this_date)
                            @if(!$loop->first) <hr class="my-1"> @endif
                            <p class="text-center my-1">{{ $this_date }}</p>
                        @endif

                        <div class="chat-content-{{ $item->author_id != $item->user_id ? 'rightside' : 'leftside' }}">
                            <div class="d-flex">
                                <div class="flex-grow-1 me-2">
                                    @if($old_time != $this_time)
                                        <p class="mb-0 chat-time {{ $item->author_id != $item->user_id ? 'text-end' : '' }}">{{ $item->created_at->format('H:i') }}</p>
                                    @endif
                                    <p class="chat-{{ $item->author_id != $item->user_id ? 'right' : 'left' }}-msg">{!! $item->text !!}</p>
                                </div>
                            </div>
                        </div>

                        @php
                            $old_date = $this_date;
                            $old_time = $this_time;
                        @endphp
                    @empty
                        <p class="text-center">Сообщений не найдено</p>
                    @endforelse
                </div>
            </div>
            <div class="chat-footer d-flex align-items-center">
                <div class="flex-grow-1 pe-2">
                    <input type="text" name="text" class="form-control" placeholder="Введите текст" required>
                </div>
                <div class="chat-footer-menu">
                    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('send_message').submit();">
                        <i class="fadeIn animated bx bx-navigation"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .chat-content {
            margin-left: 0px;
            padding: 15px
        }
        .chat-footer {
            position: relative;
            left: 0px;
        }
    </style>
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-chat-box.js') }}"></script>
@endpush
