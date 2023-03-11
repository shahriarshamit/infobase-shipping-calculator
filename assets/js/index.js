
$(document).on('keyup', '#zip', function () {
    var zip_in = $(this);
    var zip_box = $('#zip');
    var cou = $('#country').val();
    if (zip_in.val().length < 4) {
        zip_box.removeClass('error success');
    } else if (zip_in.val().length > 8) {
        zip_box.addClass('error').removeClass('success');
    } else if (cou === 'GB') {
        $.ajax({
            url: "http://api.postcodes.io/postcodes/" + zip_in.val(),
            cache: false,
            dataType: "json",
            type: "GET",
            success: function (results, success) {
                jQuery("#city").val(results.result.region);
                jQuery("#state").replaceWith('<input class="form-control" type="text" name="state" id="txtCity" />');
                jQuery("#txtCity").val(results.result.country);
                zip_box.addClass('success').removeClass('error');
            },
            error: function (results, success) {
                zip_box.removeClass('success').addClass('error');
            }
        });
    } else if ((zip_in.val().length === 4) || (zip_in.val().length === 5)) {
        $.ajax({
            url: "https://api.zippopotam.us/" + cou + '/' + zip_in.val(),
            cache: false,
            dataType: "json",
            type: "GET",
            success: function (result, success) {
                places = result['places'][0];
                jQuery("#city").val(places['place name']);
                jQuery("#state").replaceWith('<input class="form-control" type="text" name="state" id="txtCity" />');
                jQuery("#txtCity").val(places['state']);
                jQuery("#state_field .select2").hide();
                zip_box.addClass('success').removeClass('error');
            },
            error: function (result, success) {
                zip_box.removeClass('success').addClass('error');
            }
        });
    }
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
                height: $('#height').val(),
                ups: parseInt($('#ups').val())
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
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function () {
            $('#cover-spin').hide(0);
        }
    });
});

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).attr('data-value')).select();
    document.execCommand("copy");
    $temp.remove();
}
