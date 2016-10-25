$("#date").datepicker({format: 'yyyy-mm-dd'});
function clearDate() {
    $("#date").val("");
}
function loadData(page) {
    $.ajax({
        type: "POST",
        url: "/transaction/list",
        data: "page=" + page,
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
    var model = $("#model").val();
    var user = $("#user").val();
    
    $.ajax({
        type: "POST",
        url: "/transaction/filter",
        data: "transid=" + transid + "&date=" + date + "&type=" + type + "&flow=" + flow + "&model=" + model + "&uname=" + user ,
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
    $.ajax({
        type: "POST",
        url: "/transaction/clearfilter",
        data: "clear=1",
        cache: false,
        success: function (msg)
        {
            loadData(1);
        }

    });
}

function generateBill() {
    $.ajax({
        type: "POST",
        url: "/transaction/generateweek",
        data: "clear=1",
        cache: false,
        success: function (msg)
        {
            //loadData(1);
            console.log(msg);
            //location.reload();
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
    $('#btnGenerate').live('click', function () {
        generateBill();
    });
    $('.trans-tbl-wrap .pagination li').live('click', function () {
        var page = $(this).attr('p');
        loadData(page);
    });

});