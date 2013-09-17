<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
        <title>Faculty Profile</title>
        <link rel="stylesheet" type="text/css" href="css/meta1.css" />
        <link rel='stylesheet' type='text/css' href='styles/index.css' />
        <link href='styles/style1.css' rel='stylesheet' type='text/css' />
        <link href='styles/list.css' rel='stylesheet' type='text/css' />

        <script type='text/javascript' src='scripts/bp_f.js'></script>
        <script type='text/javascript'>
           
            function toggleWebtools()
            {
                var el = document.getElementById("txst-banner-webtools-menuitems");
                el.style.display = (el.style.display != 'block' ? 'block' : 'none' );
                
            }
            
            function hideMenu() //added by Sailaja
            {
               var el = document.getElementById("txst-banner-webtools-menuitems");
               el.style.display =  'none' ;
            }
</script>

<!-- Google Analytics
id:research.profiles.system@gmail.com
pwd:profilesystempass
-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30419141-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- End Google Analytics Tracking Code -->



          <?php
        if ($_POST['page-script1'] != "") {
            echo $_POST['page-script1'];
            echo "\n";
        }
        if ($_POST['page-script2'] != "") {
            echo $_POST['page-script2'];
            echo "\n";
        }
        if ($_POST['page-script3'] != "") {
            echo $_POST['page-script3'];
            echo "\n";
        }
        if ($_POST['page-script4'] != "") {
            echo $_POST['page-script4'];
            echo "\n";
        }
        if ($_POST['page-script5'] != "") {
            echo $_POST['page-script5'];
            echo "\n";
        }
        if ($_POST['page-script6'] != "") {
            echo $_POST['page-script6'];
            echo "\n";
        }
        ?>
    </head>
 <body onlick="hideMenu()">
        <div class="txst-mainsite txst-mainsite-home">
            <div class="txst-mainsite-frame">
                
        <div class="txst-mainsite-banner">
    <a href="http://www.txstate.edu/">
        <img src="uploads/mainsite-logo.png" alt="Texas State University Logo" class="txst-banner-homelink"/>
    </a>
    <div class="txst-banner-toolsandsearch">
        <div class="txst-banner-webtools-menuheader">
            <a href="#" id="txst-banner-webtools-dropdown" onclick="toggleWebtools()" >Web Tools</a> 
        </div>
        <form action="http://search.txstate.edu/search">
            <div class="txst-banner-search">
                <div style="display: none;">
                    <label for="q">Search for:</label>
                </div>
                <input type="text" name="q" id="q" size="15" value="Search web/people"/>
                <input type="hidden" name="site" value="txstate_no_users"/>
                <input type="hidden" name="client" value="txstate"/>
                <input type="hidden" name="output" value="xml_no_dtd"/>
                <input type="hidden" name="proxystylesheet" value="txstate"/>
               
               
            </div>
            <div class="txst-banner-webtools-searchbg">
                <input type="image" src="uploads/x.gif"
                       class="txst-banner-toolssearchbutton" alt="Start Search"/>
            </div>
        </form>
        <div class="txst-banner-webtools-menuitems" id="txst-banner-webtools-menuitems" >
            <div class="png-bg"><div class="txst-banner-webtools-menuitem" >
                    <a href="http://synergy.txstate.edu" >Bobcat Mail</a>
                </div>
                <div class="txst-banner-webtools-menuitem">
                    <a href="https://catsweb.txstate.edu/app/auth?/app/pay-your-accounts">Pay Tuition</a>
                </div>
                <div class="txst-banner-webtools-menuitem">
                    <a href="http://catsweb.txstate.edu/catsweb/index.htm">Catsweb</a>
                </div>
                <div class="txst-banner-webtools-menuitem">
                    <a href="http://www.maps.txstate.edu/">Maps</a>
                </div>
                <div class="txst-banner-webtools-menuitem">
                    <a href="http://www.library.txstate.edu/">Library</a>
                </div>
                <div class="txst-banner-webtools-menuitem">
                    <a href="https://tracs.txstate.edu/portal/login">TRACS</a>
                </div>
                <div class="clearboth"></div>

            </div>
            <div class="dropshadow">
                <div class="dropshadow-left"></div>
                <div class="dropshadow-right"></div>
                <div class="dropshadow-bottom"></div>
                <div class="dropshadow-leftcorner"></div>
                <div class="dropshadow-rightcorner"></div>
                <div class="dropshadow-lefttop"></div>
                <div class="dropshadow-righttop"></div>

            </div>

        </div>

    </div>
    <div class="txst-mainsite-banner-links">
        <a href="http://www.txstate.edu/about.html" class="txst-mainsite-banner-link-left">About Texas State</a>
        <a href="http://www.txstate.edu/library.html">Library</a>
        <a href="http://www.txstate.edu/maps.html">Maps</a>
        <a href="http://www.txstate.edu/round-rock.html" class="txst-mainsite-banner-link-right">Round Rock</a>
    </div>
    <div class="txst-mainsite-systemstatement">
        <img src="uploads/systemstatement.gif"
             alt="A member of the Texas State University System" />
    </div>
</div>
               
