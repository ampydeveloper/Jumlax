function searchForm(item) {
    $("#flight-from").val($(item).attr('data-from'));
    $(".from-list").toggle();
}
function searchTo(item) {
    $("#flight-to").val($(item).attr('data-to'));
    $(".from-list-to").toggle();
}
$(document).ready(function () {

//load countries    
    $(".flight-type").on('change', function () {
        if (this.value == 'oneway') {
            $("#return").hide();
            $(".return").removeAttr('required');
            $(".return").val('');
        } else {
            $("#return").show();
        }

    });
    $('#flight-from').on('click', function () {
        $(".from-list").toggle();
    })
    $(".search-from li").on('click', function () {
        $("#flight-from").val($(this).attr('data-from'));
        $(".from-list").toggle();
    });

    $("#flight-from").on('keypress', function (e) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: '/get-lisit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, message: this.value},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                var newData;
                $('.search-from').html('');
                setTimeout(function () {
                    if (data && data.status) {
                        var total = data.data.length;
                        var html = '';
                        for (var i = 0; i < total; i++) {
                            if (data.data[i].name) {
                                html += '<li onClick="searchForm(this);" data-from="' + data.data[i].iatacode + '"> <span>' + data.data[i].name + ',' + data.data[i].countryName + '<p>' + data.data[i].iatacode + '</p></span></li>';
                            }
                        }
                        $(".search-from").append(html);
                    }
                }, 2000);
            }
        });

    })


    $('#flight-to').on('click', function () {
        $(".from-list-to").toggle();
    })
    $(".search-to li").on('click', function () {
        $("#flight-to").val($(this).attr('data-to'));
        $(".from-list-to").toggle();
    });
    $("#flight-to").on('keypress', function (e) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: '/get-lisit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, message: this.value},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                var newData;
                $('.search-to').html('');
                setTimeout(function () {
                    if (data && data.status) {
                        var total = data.data.length;
                        var html = '';
                        for (var i = 0; i < total; i++) {
                            if (data.data[i].name) {
                                html += '<li onClick="searchTo(this);" data-to="' + data.data[i].iatacode + '"> <span>' + data.data[i].name + ',' + data.data[i].countryName + '<p>' + data.data[i].iatacode + '</p></span></li>';
                            }
                        }
                        $(".search-to").append(html);
                    }
                }, 2000);
            }
        });

    })
});