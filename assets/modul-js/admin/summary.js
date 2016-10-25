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

function loadDataForBill(page) {
    $.ajax({
        type: "POST",
        url: "/transaction/bill/list",
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
    var week = $("#week").val();
    
    $.ajax({
        type: "POST",
        url: "/transaction/filter",
        data: "transid=" + transid + "&date=" + date + "&type=" + type + "&flow=" + flow + "&model=" + model + "&uname=" + user + "&week=" + week ,
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

   //alert('Weekly bill generated'); 
    $.ajax({
        type: "POST",
        url: "/transaction/generateweek",
        data: "clear=1",
        cache: false,
        success: function (msg)
        {
            //loadData(1);
            //alert(msg);
            //location.reload();
            //alert("Successfully Executed for " + msg + " transaction");
            alert(msg);
        }

    });
}

function flushGenerate() {

   //alert('Weekly bill generated'); 
    $.ajax({
        type: "POST",
        url: "/transaction/flush",
        data: "clear=1",
        cache: false,
        success: function (msg)
        {
            //loadData(1);
            //alert(msg);
            //location.reload();
            alert(msg + " center flushed");
        }

    });
}


function saveToHistory() {
       //alert('Weekly bill generated'); 
    $.ajax({
        type: "POST",
        url: "/transaction/savetohistory",
        data: "clear=1",
        cache: false,
        success: function (msg)
        {
            //loadData(1);
            //alert(msg);
            //location.reload();
            alert("Save to History , Ready for generate");
        }

    });
}


function genPDF() {

    if (confirm('YES for only Bill Sheet , NO for prepare for Generate')) {
        doPDF();
    } else {
        if (confirm('YOU MUST BE SERIOUS WHAT YOUR ARE DOING ! YES FOR CANCEL , NO FOR PROCEED')) {
            alert("CANCEL");
        } else {
            doPDF();
            saveToHistory();

        }
    }

}

function doPDF() {
        var dateClass = new Date()
    var date = dateClass.toJSON().slice(0,10);
    
    // https://github.com/simonbengtsson/jsPDF-AutoTable

    var doc = new jsPDF('l', 'pt');

    var header = function (data) {
        doc.setFontSize(20);
        doc.setTextColor(40);
        doc.setFontStyle('normal');

        doc.text("GOLDENSTAR BANGLADESH (PVT.) LTD.", data.settings.margin.left + 165, 55);

        
        doc.setFontSize(11);
        doc.setTextColor(100);
        doc.setTextColor(40);
        var text = "Registration No : C129765/2016";
        doc.text(text, 310, 72);


    };

    var totalPagesExp = "{total_pages_count_string}";
    var footer = function (data) {
        var str = "Page " + data.pageCount  ;
        // Total page number plugin only available in jspdf v1.0+
        if (typeof doc.putTotalPages === 'function') {
            str = str ;
        }
        doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
    };


    var options = {
        theme: 'grid',
        beforePageContent: header,
        afterPageContent: footer,
        margin: {top: 90},
        bodyStyles: {rowHeight: 14, fontSize: 10, valign: 'middle'}
    };

    var elem = document.getElementById("trans-tbl");
    var res = doc.autoTableHtmlToJson(elem);    
   
    doc.autoTable(res.columns, res.data, options);
    
    doc.save("billsheet_"+date+".pdf");
    
    alert("PDF Generated ! " );

}


$(document).ready(function () {

    var path = window.location.pathname;
    if(path =="/transaction") {
        loadData(1);
    } else {
        loadDataForBill(1);
    }

    

    $('#filter').live('click', function () {
       $(this).html("<i class='fa fa-search'></i> PLEASE WAIT..")
        $(this).attr("disabled", true);
        filter();
    });
    $('#clearfilter').live('click', function () {
        clearfilter();
    });
   
    $('#genPdf').live('click', function () {
        genPDF();
    });

    $('#btnFlush').live('click', function () {
        flushGenerate();
    });
    



    $('.trans-tbl-wrap .pagination li').live('click', function () {
        var page = $(this).attr('p');
        loadData(page);
    });


    $("#dialog").dialog({
       autoOpen: false,
       modal: true,
       buttons : {
            "Confirm" : function() {
                generateBill();   
                $(this).dialog("close");       
            },
            "Cancel" : function() {
              $(this).dialog("close");
            }
          }
        });

    $("#btnGenerate").on("click", function(e) {
        e.preventDefault();
        $("#dialog").dialog("open");
    });




});