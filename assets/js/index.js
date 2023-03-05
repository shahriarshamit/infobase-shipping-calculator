
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on('click', '#process', function (event) {
    event.preventDefault();
    $.ajax({
        url: $('#form-calculate').attr('action'),
        type: $('#form-calculate').attr('method'),
        data: {
            cal: {
                process: 'calculate',
                country: $('#country').val(),
                city: $('#city').val(),
                zip: $('#zip').val(),
                weight: $('#weight').val(),
                quantity: $('#quantity').val(),
                length: $('#length').val(),
                width: $('#width').val(),
                height: $('#height').val()
            }
        },
        beforeSend: function (xhr, settings) {
            $('#result-html').html('');
            $('#cover-spin').show(0);
        },
        success: function (response, textStatus, xhr) {
            var result = JSON.parse(response);
            $('#result-html').html(result.output);
            $('#cover-spin').hide(0);
        },
        error: function () {
            $('#cover-spin').hide(0);
        }
    });
});

function copyToClipboard(element) {
    console.log(element);
//    var $temp = $("<input>");
//    $("body").append($temp);
//    $temp.val($(element).text()).select();
//    document.execCommand("copy");
//    $temp.remove();
}
