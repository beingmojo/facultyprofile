<?php
$_POST['page-title'] = "Home";  
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
include_once 'includes/page-top.php';
?>
<script type="text/javascript">

function validate(){
if( (document.getElementById('passwd').value)=="")
  {
  alert("Please enter valid id and password");
return false;
}
}
</script>

<link href="video-js/video-js.css" rel="stylesheet" />
<script src="video-js/video.js"></script>

</head>
<table width="100%" border="0">
    <tr><!-- Page center image -->
        <td width="20%"></td>
        <td colspan="3" width="60%" align="center">
            <a href="http://www.txstate.edu/research">
                <img src="images/canoe6.JPG" alt="Research Expertise at Texas State University" border="0" />
            </a>
        </td>
        <td width="20%"></td>
    </tr>
    <tr><!-- Links beneath page center image -->
        <td width="20%"></td>
        <td colspan="3" width="60%" align="center">
            <span>
                <a href="http://www.txstate.edu/research" title="Research at Texas State University">Research at Texas State University </a>&nbsp;&nbsp;
            </span>
            <img src="images/bullet.gif" alt="bullet" height="4" width="4" />&nbsp;&nbsp;
            <span>
                <a href="http://www.txstate.edu/research/" title="Associate Vice President for Research and Federal Relations">AVP for Research</a>&nbsp;&nbsp;
            </span>
            <img src="images/bullet.gif" alt="bullet" height="4" width="4" />&nbsp;&nbsp;
            <span>
                <a href="aboutrps.php" title="About RPS">About RPS</a>&nbsp;&nbsp;
            </span>
            <img src="images/bullet.gif" alt="bullet" height="4" width="4" />&nbsp;&nbsp;
            <span>
                <a href="help/index.php" title="Help">Help</a>&nbsp;&nbsp;
            </span>
            <img src="images/bullet.gif" alt="bullet" height="4" width="4" />&nbsp;&nbsp;
            <span>
                <a href="feedback.php" title="Provide Feedback">Provide Feedback</a>&nbsp;&nbsp;
            </span>
            <img src="images/bullet.gif" alt="bullet" height="4" width="4" />&nbsp;&nbsp;
            <span>
                <a href="loginscreen.php" title="Login">Login</a>
            </span>
        </td>
        <td width="20%"></td>
    </tr>
    <tr><!-- Horizontal bar beneath links beneath page center image -->
        <td width="20%"></td>
        <td colspan="3" width="60%" align="center"><hr size="5px" style="color:#CCCCCC" noshade="noshade" /></td>
        <td width="20%"></td>
    </tr>
    <tr><!-- Main content after horizontal bar -->
        <td width="20%"></td>
        <td width="17%" align="left" valign="top">
            <br /><h1>Browse</h1><br />
            <div><a href="browseprofiles.php?view=1">Faculty Profiles</a></div>
            <div><a href="browseprofiles.php?view=2">Research Center Profiles</a></div>
            <div><a href="browseprofiles.php?view=3">Technology Profiles</a></div>
            <!--//disabled facilities n labs// <div><a href="browseprofiles.php?view=4">Facility Profiles</a></div>-->
            <div><a href="browseprofiles.php?view=5">Equipment Profiles</a></div>
<!--            <br /><h1>Search Options</h1><br />
            <div ><a href="advsearch.php">Advanced Search</a></div>
            <div><a href="clustersearch.php">Cluster Search <span class="style1">*</span></a></div>
            <div><a href="graphnew.htm">Interactive Search <span class="style1">*</span></a></div>
            <div>(<span class="style1">*</span> under construction)</div> -->
            <br /><h1>Browse Options</h1><br />
            <div><a href="courses.php">Courses</a></div>
        </td>
        <td width="23%" align="left" valign="top">
            <br /><h1>Search Expertise at Texas State</h1><br />
            <form action="searchresults.php" method="get" name="search" id="search">
                <label for="faculty"><input name="faculty" class="more" id="faculty" value="true" checked="checked" type="checkbox" align="left" />
                    <a href="browseprofiles.php?view=1"><img src="images/bullets/faculty.gif" alt="&gt;" width="12" height="12" border="0" /> Faculty / Expertise</a></label><br />
                <label for="researchcenter"><input name="researchcenter" class="more" id="researchcenter" value="true" checked="checked" type="checkbox" />
                    <a href="browseprofiles.php?view=2"><img src="images/bullets/center.gif" alt="&gt;" width="12" height="12" border="0" /> Research Centers</a></label> <br />
                <label for="technology"><input name="technology" class="more" id="technology" value="true" checked="checked" type="checkbox" />
                    <a href="browseprofiles.php?view=3"><img src="images/bullets/technology.gif" alt="&gt;" width="12" height="12" border="0" /> Technologies and Patents</a></label><br />
                    <label for="equipment"><input name="equipment" class="more" id="equipment" value="true" checked="checked" type="checkbox"/>
                    <a href="browseprofiles.php?view=5"> <img src="images/bullets/equipment.gif" alt="&gt;" width="12" height="12" border="0" /> Equipment</a></label> <br />

                  <!--//disabled facilities n labs// <label for="facility"><input name="facility" class="more" id="facility" value="true" checked="checked" type="checkbox" />
                    <a href="browseprofiles.php?view=4"><img src="images/bullets/facility.gif" alt="&gt;" width="12" height="12" border="0" /> Research Facilities</a></label><br />
                <label for="labgroup"><input name="labgroup" class="more" id="labgroup" value="true" checked="checked" type="checkbox" />
                    <a href="browseprofiles.php?view=6"><img src="images/bullets/labgroup.gif" alt="&gt;" width="12" height="12" border="0" /> Laboratories and Research Groups</a></label> <br /> -->
                <br /><div class="rsp" align="left" style="color:#580000">Enter Keyword</div><br />
                <label for="search">
               <input name="search" class="rsp" id="search" onfocus="if(this.value==' search...')
                   this.value=''; " onblur="
                   if(this.value=='') this.value=' search...';" value=" search..." size="20" type="text" /></label>
                <input name="searchtype" value="basic" type="hidden" />
                <input name="image2" type="image" src="images/arrow3.gif" alt="Search RPS..." align="bottom"/>
            </form>
            
        </td>
        <td width="20%" align="left" valign="top">
            <br /><h1>Faculty & Staff Login</h1><br />
            <form action="f_login.php" method="post" enctype="application/x-www-form-urlencoded" name="login" id="login" onSubmit="return validate()">
                 <!-- onSubmit="return validate()">-->
                <table width="230" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                        <td class="rsp"><div align="left">Texas State Net ID</div></td>
                        <td colspan="2" class="rsp"><div align="left">Password</div></td>
                    </tr>
                    <tr>
                        <td><div align="left"><label for="uid"><input name="uid" type="text" class="rsp" id="uid" size="10" /></label></div></td>
                        <td><div align="left"><label for="passwd"><input name="passwd" type="password" class="rsp" id="passwd" size="10" /></label></div></td>
                        <td>
                            <div align="left">
                                <input name="image" type="image" class="searchimage"  src="images/arrow3.gif" alt="Login" align="bottom" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer"><div align="left"><a href="https://catsweb.txstate.edu/app/auth?/app/password">[ Forgot Password ]</a></div></td>
                        <td class="footer" colspan="2"><div align="left"><a href="help/#login">[ Need More Help ] </a></div></td>
                    </tr>
                </table>
                <br />
              
            </form>
        </td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%"></td>
        <td colspan="3" align="center">
            &nbsp;
        </td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%"></td>
        <td colspan="3" align="center">
            <label>Tutorial:</label>
            <video id="tVideo" 
                   class="video-js vjs-default-skin" 
                   data-setup='{"controls":true, "autoplay":false, "preload":"auto"}' 
                   height="360" 
                   width="420">
                <source src="video/video1_edit.mp4" type='video/mp4'>
                <source src="video/video1_edit.ogg" type='video/ogg; codecs="theora, vorbis"'>
                <source src="video/video1_edit.webm" type='video/webm; codecs="vp8.0, vorbis"'>
                <object data="video/video1_edit.mp4" height="360">
                    <embed src="video/video1_edit.mp4" height="360">
                </object>
                <br/>
                <br/>
                <font color="red">Can't play video. Please Upgrade your browser.</font>
            </video>
        </td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td colpan="5">
            &nbsp;
        </td>
    </tr>
    <tr><!-- Page footer -->
        <td width="20%"></td>
        <td colspan="3" width="60%" align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.uta.edu/research/collaborate/" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
        <td width="20%"></td>
    </tr>
</table>

</div>
</div>

</body>
</html>
