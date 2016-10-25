<?php global $hooks; ?>
</div> 
<footer>
    <p>Copyright © <?php echo date("Y"); ?> GOLDENSTAR Bangladesh Pvt LTD</p> 
</footer>
<!--footer section end-->


</div>
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="/assets/js/jquery-1.10.2.min.js"></script>
<script src="/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/modernizr.min.js"></script>

<!--easy pie chart-->
<script src="/assets/js/easypiechart/jquery.easypiechart.js"></script>
<script src="/assets/js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="/assets/js/sparkline/jquery.sparkline.js"></script>
<script src="/assets/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="/assets/js/iCheck/jquery.icheck.js"></script>
<script src="/assets/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="/assets/js/flot-chart/jquery.flot.js"></script>
<script src="/assets/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/assets/js/flot-chart/jquery.flot.resize.js"></script>


<!--Morris Chart-->
<script src="/assets/js/morris-chart/morris.js"></script>
<script src="/assets/js/morris-chart/raphael-min.js"></script>

<!--Calendar-->
<script src="/assets/js/calendar/clndr.js"></script>
<script src="/assets/js/calendar/evnt.calendar.init.js"></script>
<script src="/assets/js/calendar/moment-2.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="/assets/js/jquery.nicescroll.js"></script>
<!--common scripts for all pages-->

<script src="/assets/js/scripts.js"></script>

<!--Dashboard Charts-->
<script src="/assets/js/dashboard-chart-init.js"></script>
<!-- TOKENIZE -->
<script type="text/javascript" >
    $(function () {
        $.ajaxPrefilter(function (options, origOptions, jqXHR) {
            options.data = options.data + "&token="+$("#token").val();
        });
    });
</script>
<!-- Global JS -->
<?php $hooks->do_action("global_js"); ?>

</body>
</html>