<style>
    .mail {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        background-color: #ffffff;
        border-color: #e8e5ef;
        border-radius: 2px;
        border-width: 1px;
        margin: 0 auto;
        padding: 0;
        width: 100%;
        max-width: 815px;
    }
    .border-b {
        border-bottom: 1px solid #B7B6B2;
        padding: 35px 15px 15px;
        display: block;
        position: relative;
        text-align: center;
    }
    .size-logo {
        display: block;
    }
    .size-logo svg {
        width: 300px;
        height: auto;
    }
    .p1 {
        padding: 15px 32px;
        display: block;
    }
    .p2 {
        padding: 0 32px 10px;
        display: block;
    }
    .title p,
    .title {
        font-family: 'Playfair Display';
        color: #29654F;
        font-size: 28px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .title p span {
        font-weight: 700;
    }
    .text p,
    .text {
        font-family: 'Lato', sans-serif;
        color: #120E00;
        font-size: 16px;
        font-style: italic;
        font-weight: 400;
        line-height: normal;
    }
</style>
<div>
    <table class="mail">
        <tbody>
        <tr class="border-b">
            <td class="size-logo">
{{--                <img src="{{ asset('dist/img/logo.jpg') }}" width="132" height="59" alt="">--}}
                <p class="p1">
                    SKLAD<span style="color: red">ART</span>
                </p>
            </td>
        </tr>

        <tr class="p2">
            <td class="text">
                @yield('content')
            </td>
        </tr>
        </tbody>
    </table>
</div>
