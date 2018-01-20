$(document).ready(function (i) {
    if ($('.apply_date_picker').length > 0) {
        $('.apply_date_picker').datepicker({
            formate: "dd/mm/yyyy",
        });
    }

    //Date Range Picker
    if ($('#date_range').length > 0) {
        $('#date_range').daterangepicker({format: 'DD/MM/YYYY'});
    }

});

// function for preview invoices..
function preview_invoice() {
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
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
            $("#wait").css("display", "none");
        },
        error: function () {
            $("#wait").css("display", "none");
            alert('Please select Client and Date Range');
        }
    });
}