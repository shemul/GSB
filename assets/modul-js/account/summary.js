$("#date").datepicker({format: 'yyyy-mm-dd'});
function clearDate() {
    $("#date").val("");
}
function loadData(page) {
    var token = $("#token").val();
    $.ajax({
        type: "POST",
        url: "/account/fund-summary/list",
        data: "page=" + page + "&token=" + token,
        cache: false,
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (msg)
        {
            $(".trans-tbl-wrap").ajaxComplete(function (event, request, settings)
            {
                //loading_hide();
                $(".trans-tbl-wrap").html(msg);
                $('#trans-tbl').footable();
            });
        }

    });

}
function filter() {
    var transid = $("#transid").val();
    var date = $("#date").val();
    var type = $("#transtype").val();
    var flow = $("#transflow").val();
    var token = $("#token").val();
    $.ajax({
        type: "POST",
        url: "/account/fund-summary/filter",
        data: "transid=" + transid + "&date=" + date + "&type=" + type + "&flow=" + flow + "&token=" + token,
        cache: false,
        success: function (msg)
        {
            loadData(1);
            $("#filter").html("<i class='fa fa-search'></i> FILTER");
            $("#filter").attr("disabled", false);
        }

    });
}
function clearfilter() {
    var token = $("#token").val();
    $.ajax({
        type: "POST",
        url: "/account/fund-summary/clearfilter",
        data: "clear=1&token=" + token,
        cache: false,
        success: function (msg)
        {
            loadData(1);
        }

    });
}
$(document).ready(function () {
    loadData(1);
    $('#filter').live('click', function () {
        $(this).html("<i class='fa fa-search'></i> PLEASE WAIT..")
        $(this).attr("disabled", true);
        filter();
    });
    $('#clearfilter').live('click', function () {
        clearfilter();
    });
    $('.trans-tbl-wrap .pagination li').live('click', function () {
        var page = $(this).attr('p');
        loadData(page);
    });

});