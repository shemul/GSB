
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Southern University Bangladesh</title>
<meta name="keywords" content="Southern University Degree, Southern University result, southern university Studnets" />
<meta name="description" content="Southern University Degree" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>
<!-- gallery css-->
<link href="css/slider_css.css" rel="stylesheet" type="text/css" />


<!--<script src="js/jquery-1.7.1.min.js"></script>-->

<link rel='stylesheet' type='text/css' href='css/menu.css' />

<!-- gallery css end-->

<!--dropdown menu css-->
<link rel="stylesheet" type="text/css" href="css/flexdropdown.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/flexdropdown.js"></script>
<!--dropdown menu css-->
<script type="text/javascript" src="jquery-1.2.6.min.js"></script>
    
<script type="text/javascript">

/*** 
    Simple jQuery Slideshow Script
    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
***/

function slideSwitch() {
    var $active = $('#slideshow div.active');

    if ( $active.length == 0 ) $active = $('#slideshow div:last');

    // use this to pull the divs in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slideshow div:first');

    // uncomment below to pull the divs randomly
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

</script><script language="javascript" type="text/javascript">
    function printDiv(printme) {
        //Get the HTML of div
        var divElements = document.getElementById(printme).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }
</script>
</head>
<body>
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
	    
    <div id="templatemo_header">
    	<div class="templatemo_webpanel">
        	<a href="/webmail" class="border_right"> Webmail </a>
            <a href="result.php" class="border_right"> Result Verification </a>
            <a href="login.php"> Login </a>
        </div>
        <div id="site_title"><h1><a href="#">Southern University</a></h1></div>
        
 <!--       <div id="search_box">
            <form action="#" method="get">
                <input type="text" value="Search" name="q" size="10" id="searchfield" title="searchfield" onfocus="clearText(this)" onblur="clearText(this)" />
            </form>
        </div>-->
        
    </div> <!-- end of templatemo header -->
    
	    <div id="templatemo_menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php" data-flexmenu="flexmenu1">About</a>
                <!-- start-->
                   <ul id="flexmenu1" class="flexdropdownmenu">
                        <li><a href="missionvission.php">Mission &amp; Vission</a></li>
                        <li><a href="accreditation.php">Accreditation</a></li>
                        <li><a href="messagevc.php">Message - VC</a></li>
                        <li><a href="messagefounder.php">Message Founder</a></li>
                        <li><a href="bod.php">Member of Trustee</a></li>
                        <li><a href="unsouthern.php">UN-Southern</a></li>
                  </ul>
                <!--end -->
            </li>
            <li><a href="faculty.php" data-flexmenu="flexmenu2">Academics</a>
                <!-- start-->
                   <ul id="flexmenu2" class="flexdropdownmenu">
                        <li><a href="faculty.php">Faculty Member</a></li>
                        <li><a href="researchandjournals.php">Research &amp; Journals</a></li>
                        <li><a href="departments.php">Departments</a></li>
                  </ul>
                <!--end -->
            </li>
            <li><a href="faculty.php">Faculty</a></li>
            <li><a href="underconstruction.php">Administration</a></li>
            <li><a href="admission.php?id=1"  data-flexmenu="flexmenu5">Admission</a>
                    <!-- start-->
                       <ul id="flexmenu5" class="flexdropdownmenu">
                            <li><a href="admission.php?id=1">Requirements</a></li>
                            <li><a href="admission.php?id=5">Information</a></li>
                            <li><a href="admission.php?id=2">Tution &amp; Other Fees</a></li>
                            <li><a href="admission.php?id=3">Financial Assitance</a></li>
                            <li><a href="admission.php?id=4">Cradit Transfer</a></li>
                            <li><a href="#">Download Form</a></li>
                      </ul>
                    <!--end -->
            </li>
            <li><a href="carier.php">Career</a></li>
            <li><a href="course.php" data-flexmenu="flexmenu6">Course</a>
                     <!-- start-->
                       <ul id="flexmenu6" class="flexdropdownmenu">
                            <li><a href="c.php?id=1">Graduate</a></li>
                            <li><a href="c.php?id=2">Under Graduate</a></li>
                            <li><a href="c.php?id=3">H N D</a></li>
                            <li><a href="c.php?id=4">National Diploma</a></li>
                            <li><a href="c.php?id=5">Diploma</a></li>
                      </ul>
                    <!--end -->
            </li>
            <!--<li><a href="portfolio.php">Photo Gallery</a></li>-->
            <li><a href="information.php">Our Information Centre</a></li>
            <li><a href="contact.php" class="last">Contact</a></li>
        </ul>     	
    </div> <!-- end of templatemo_menu -->    <div  id="printme">
    <!--gallery code start from here--><!-- gallery code end here -->
    <table  border="0" align="center" cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <td valign="top"> 
                                    <table width="100%" align="center" border="0" style="background:url(images/upper-portion.png) no-repeat left center #312783; width:706px;">
                              <tr>
                                <td height="5" colspan="2"></td>
                                <td width="60" style="text-align:center; border:5px #000000 solid; width:100px;"><img src="admin/access/photo/1421203011.jpg" width="120" height="118" /></td>
                              </tr>
                                    </table>
									<table width="100%" align="center" border="0" style="width:708px; background:#312783;">
                              <tr>
                              <td colspan="2">
                                                         			<div id='cssmenu'>
                                <ul>
                                      <li><a href='s_mark.php?sid=110326&amp;pr=Bachelor of Business Administration (BBA)&amp;rollnumber=1220110326&amp;status=0'>
                                          <span>View Academic Transcript</span></a></li>
                                          
                                         <li><a href='s_mark.php?sid=110326&amp;pr=Bachelor of Business Administration (BBA)&amp;rollnumber=1220110326&amp;status=1'><span>View Testimonial</span></a></li>
                                         <li><a href='s_mark.php?sid=110326&amp;pr=Bachelor of Business Administration (BBA)&amp;rollnumber=1220110326&amp;status=2'><span>View Migration Certificate</span></a> </li>
                                         <li><a href='s_mark.php?sid=110326&amp;pr=Bachelor of Business Administration (BBA)&amp;rollnumber=1220110326&amp;status=3'><span>View Provisional Certificate <!--(Only for completed student)--></span></a></li>
                                 </ul>
                         		 </div>
                                       
                                 </td>
                                 </tr>
                                 </table>
                                     <img width="700"  style="margin-top:5px;" src="admin/access/photo/ip_1421351625_page5output.jpg">                               </td>
                            </tr>
                        </table>
                        <br /><br />
                    <table width="381" border="0" align="center">
                        <tr>
                            <th scope="col"><input type="button" style="height:50px; padding-left:20px; padding-right:20px; line-height:50px; " value="Print Academic Transcript " onclick="javascript:printDiv('printme')" /></th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                    </table>
 </div>
    
    <div id="templatemo_main">
      <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="templatemo_main_bottom"></div>
	<div class="cleaner"></div>
</div> <!-- end of templatemo wrapper -->
</div> <!-- end of templatemo body wrapper -->

<div id="templatemo_footer_wrapper">

	

  <div id="templatemo_footer_border">

    	<div class="templatemo_footer_boxa">

        	<div class="boxa_head">

            	<div class="boxa_head_title"><strong><a href="about.php">About Us</a></strong></div>

                <div class="boxa_head_title"><strong><a href="accreditation.php">Academic</a></strong></div>

                <div class="boxa_head_title"><strong><a href="index.php">Quick Link</a></strong></div>

            </div>

            <div class="boxa_head_link">

            	<div class="boxa_head_title_link">

                    <div class="title_link"><a href="index.php">Home</a> </div>

                    <div class="title_link"><a href="about.php">About us</a> </div>

                    <div class="title_link"><a href="contact.php">Contact Us </a></div>

                </div>

			</div>

            <div class="boxa_head_link">

            	<div class="boxa_head_title_link">

                    <div class="title_link"><a href="index.php">Academic Calender</a></div>

                    <div class="title_link"><a href="index.php">Admission 2016</a></div>

                    <div class="title_link"><a href="index.php">Faculty Memeber</a></div>

                </div>

			</div>

            <div class="boxa_head_link">

            	<div class="boxa_head_title_link">

                    <div class="title_link"><a href="index.php">Home </a></div>

                    <div class="title_link"><a href="index.php">About Sub </a></div>

                    <div class="title_link"><a href="index.php">Contact Us </a></div>

                </div>

			</div>

        </div>

        

        

        

    <div class="templatemo_footer_boxb">

		<div class="templatemo_footer_boxb_boxinfo">

        	<div class="boxinfo_fot">

            	Southern University Bangladesh <br />

                <em>Commited to Academic Excellence</em>

            </div>

            <div class="boxinfo_fota">

				<img src="images/templatemo_logo.png" />

            </div>

        </div>

      <div class="templatemo_footer_boxb_boxinfo_a border_right" style="width:160px;">

       	<div class="templatemo_footer_boxb_boxinfo_a_follow">Follow Us</div> 

          <a class="a_follow" href="#"><div class="imgfollow"></div></a> 

        </div>

        <div class="templatemo_footer_boxb_boxinfo_a" style="width:210px;">

        	<div class="templatemo_footer_boxb_boxinfo_a_follow" style="font-size:18px; padding-left:4px; text-align:center;"> 
            Call : 
			+8801722344966            
            </div> 

        </div>		

    </div>

  </div>

	<div id="templatemo_footer">

    	Copyright © <a href="#" title="AMS IT">Southern University</a> - 

        Designed &amp; Developed by <a href="#" target="_parent" title="AMS IT">Southern IT</a>

      <div class="cleaner"></div>

	</div>

    

</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48874850-1', 'southernuniversitybd.com');
  ga('send', 'pageview');

</script></div>
</body>

</html>