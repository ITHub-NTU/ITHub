$(document).ready(function() {
    function load_unseen_notification(view = '') {
        $.ajax({
            url: "../notification/fetch.php",
            method: "POST",
            data: { view: view },
            dataType: "json",
            success: function(data) {
                $('#notification').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.badge.bg-danger').show();
                    if (data.unseen_notification > 10) {
                        $('.count').html('10<sup style="font-weight: bold;">+</sup>');
                    } else {
                        $('.count').html(data.unseen_notification);
                    }
                } else {
                    $('.count').html('');
                    $('.badge.bg-danger').hide();
                }
                if (data.unseen_message > 0) {
                    $('.countTN').show();
                    if (data.unseen_message > 10) {
                        $('.countTN').html('10<sup style="font-weight: bold;">+</sup>');
                    } else {
                        $('.countTN').html(data.unseen_message);
                    }
                } else {
                    $('.countTN').html('');
                    $('.countTN').hide();
                }
            }
        });
    }

    load_unseen_notification();

    $(document).on('click', '#thongbao', function() {
        $('.count').html('');
        load_unseen_notification('yes');
    });

    setInterval(function() {
        load_unseen_notification();
    }, 5000);
});
