
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
            $('#amount-fedex').html('0.00');
            $('#amount-ups').html('0.00');
            $('#amount-ems').html('0.00');
            $('#cover-spin').show(0);
        },
        success: function (response, textStatus, xhr) {
            var output = JSON.parse(response);
            
            $('#amount-fedex').html(output.fedex.amount);
            $('#amount-ups').html(output.ups.amount);
            $('#amount-ems').html(output.ems.amount);
            $('#cover-spin').hide(0);
        },
        error: function() {
            $('#cover-spin').hide(0);
        }
    });
});
