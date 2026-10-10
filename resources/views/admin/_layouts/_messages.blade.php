@if($errors->any() || session('success') || session('primary') || session('error'))
    @php
        if (session('success')) {
            $color = 'success';
        } elseif (session('primary')) {
            $color = 'primary';
        } elseif ($errors->any() || session('error')) {
            $color = 'danger';
        }
    @endphp

    <div class="alert border-0 bg-light-{{ $color }} alert-dismissible fade show">
        @if(session('success'))
            {!! session()->get('success') !!}
        @elseif(session('primary'))
            {!! session()->get('primary') !!}
        @elseif(session('error'))
            {!! session()->get('error') !!}
        @elseif($errors->any())
            <ul>
                @forelse($errors->all() as $error)
                    <li>{{ $error }}</li>
                @empty
                    <li>{!! session()->get('error') !!}</li>
                @endforelse
            </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{--@if($errors->any() || session('success') || session('primary') || session('error'))--}}
{{--    @push('styles')--}}
{{--        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/notifications/css/lobibox.min.css') }}" />--}}
{{--    @endpush--}}
{{--    @push('scripts')--}}
{{--        <script src="{{ asset('admin/assets/plugins/notifications/js/lobibox.min.js') }}"></script>--}}
{{--        <script src="{{ asset('admin/assets/plugins/notifications/js/notifications.min.js') }}"></script>--}}
{{--        <script src="{{ asset('admin/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>--}}
{{--        <script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>--}}
{{--        <script>--}}
{{--            function round_success_noti() {--}}
{{--                Lobibox.notify('success', {--}}
{{--                    pauseDelayOnHover:          true,--}}
{{--                    size:                       'mini',--}}
{{--                    rounded:                    true,--}}
{{--                    icon:                       'bx bx-check-circle',--}}
{{--                    delayIndicator:             false,--}}
{{--                    continueDelayOnInactiveTab: false,--}}
{{--                    position:                   'top right',--}}
{{--                    msg:                        'Lorem ipsum dolor sit amet hears farmer indemnity inherent.'--}}
{{--                });--}}
{{--            }--}}
{{--        </script>--}}

{{--        <script>--}}
{{--            let color;--}}
{{--            let text;--}}
{{--            let icon;--}}
{{--            if (@json(session('success'))) {--}}
{{--                color = 'success';--}}
{{--                text = @json(session()->get('success'));--}}
{{--                icon = 'bx bx-check-circle';--}}
{{--            } else if (@json(session('primary'))) {--}}
{{--                color = 'primary';--}}
{{--                text = @json(session()->get('primary'));--}}
{{--                icon = 'bx bx-check-circle';--}}
{{--            }  else if (@json(session('error'))) {--}}
{{--                color = 'error';--}}
{{--                text = @json(session()->get('error'));--}}
{{--                icon = 'bx bx-check-circle';--}}
{{--            } else if (@json($errors->any())) {--}}
{{--                color = 'error';--}}
{{--                text = fo;--}}
{{--                icon = 'bx bx-check-circle';--}}
{{--                for (@json($errors->any())--}}
{{--            }--}}
{{--            console.log(color, text, icon);--}}
{{--            Lobibox.notify(color, {--}}
{{--                pauseDelayOnHover: true,--}}
{{--                size: 'mini',--}}
{{--                rounded: true,--}}
{{--                icon: icon,--}}
{{--                delayIndicator: false,--}}
{{--                continueDelayOnInactiveTab: false,--}}
{{--                position: 'top right',--}}
{{--                msg: text--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endpush--}}
{{--@endif--}}
