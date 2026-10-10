// maskForm
$(document).ready(function() {
    $('input[name*="dob"]').inputmask('99.99.9999',{ "placeholder": "дд.мм.pppp" });
    $('input[name*="phone"]').inputmask('(999) 999-99-99',{ "placeholder": "x" });
    // $('input[name*="phones"]').inputmask('+99(999) 999-99-99',{ "placeholder": "x" });
    $('input[name*="time"]').inputmask('99:99',{ "placeholder": "x" });
    // $('input[name*="work_times"]').inputmask('99:99-99:99',{ "placeholder": "xx:xx-xx:xx" });
});
