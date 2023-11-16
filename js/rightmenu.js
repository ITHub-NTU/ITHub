$(document).ready(function() {
    function load_rightmenu(view = '') {
        $.ajax({
            url: "../diendan/rightmenu.php",
            method: "POST",
            data: { view: view },
            dataType: "json",
            success: function(data) {
                $('#rightmenu').html(data.rightmenu);
            }
        });
    }

    load_rightmenu();

    setInterval(function() {
        load_rightmenu();
    }, 2000);
});
