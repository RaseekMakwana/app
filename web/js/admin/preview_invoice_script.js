function test() {
    var fd = new FormData();
    var data = $('form').serializeArray();
    $.each(data, function (key, input) {
        fd.append(input.name, input.value);
    });
    $.ajax({
        type: 'POST',
        url: 'preview_invoice',
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.invoice-preview').show();
            $('#preview_invoice_data').html(data);
        },
        error: function () {
            console.error('Failed to process ajax !');
        }
    });
}
