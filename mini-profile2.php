<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--http://www.jsworkshop.com/js3e/list20-2.html-->
<html>
    <head>
        <title>Research Profile System - Texas State University - San Marcos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            a {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #444444;
            }
            a:link {
                text-decoration: none;
                /*color: #0A246A;*/
                color: #444444;
            }
            a:visited {
                text-decoration: none;
                /*color: #000000;*/
                color: #444444;
            }
            a:hover {
                text-decoration: underline;
                /*color: #000000;*/
                color: #444444;
            }
            a:active {
                text-decoration: none;
                /*color: #000000;*/
                color: #444444;
            }
            body,td,th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }
            body {

                background-color: #ffffff;
            }
            .style1 {color: #FF0000}
        </style>
        <script src="util/get_images.php"></script>
        <script type="text/javascript">
            var curimg=0
            function rotateimages() {
                var indexOfComma;
                var sub = galleryarray[curimg];
                var imageString;
                var destinationString;
                var interestsString;
                var pid;
                imageString = sub.substring(0, indexOfComma = sub.indexOf(","));
                pid = imageString.substring(0, imageString.indexOf("_"));
                sub = sub.substring(indexOfComma + 1);
                destinationString = sub.substring(0, indexOfComma = sub.indexOf(","));
                interestsString = sub.substring(indexOfComma + 1);
                //change image
                document.getElementById("image").setAttribute("src", "images/128/" + imageString);
                //change destination
                document.getElementById("designation").firstChild.nodeValue = destinationString;
                //change destination
                document.getElementById("interests").firstChild.nodeValue = interestsString;
                //change href
                var href;
                href = document.getElementById("alink").href;
                href = href.substring(0, href.indexOf("="));
                document.getElementById("alink").href = href + "=" + pid;
                //update curimg
                curimg=(curimg<galleryarray.length-1)? curimg+1 : 0;
            }
            window.onload=function() {
                rotateimages();
                setInterval("rotateimages()", 5000);
            }
            function ChangeDesignation() {
            }
        </script>
    </head>
    <body>
        <div class='navigation' align="center" style="font-size:10px">
            <a id="alink" target="_top" href="editprofile.php?pid=" style="font-size:10px">Link</a>
        </div><br />
        <div style="width: 240px; height: 500px" align="center">
            <img id="image" src="" alt="...research showcase slideshow..." />
            <p>
                <div id="designation">.</div><br />
                <div id="interests">.</div>
            </p>
        </div><br />
    </body>
</html>
