<?php

include_once '../includes/debug.php';
include_once '../includes/db.php';

//Coming back from a POST
if(isset($_POST['hd'])){
    $allowedExts = array("csv", "txt");
    $temp = explode(".", $_FILES['file']['name']);
    $extension = end($temp);
    $names = array();
    
    $mysqli = mysqlConnect();
    
    if(in_array($extension, $allowedExts)){
        if($_FILES['file']['error'] > 0){
            echo "Error: " .$_FILES['file']['error'] . "<br />";
            exit();
        }
        else{
            $filename = "/var/www/facultyprofile-docs/" . $_FILES['file']['name'];
            if(file_exists($filename))
                unlink ($filename);
            move_uploaded_file($_FILES['file']['tmp_name'], $filename);
            echo "Stored in: $filename<br />";
            
            $file = fopen($filename, "r") or exit("Unable to open file!");
            
            while(!feof($file)){
                $names[] = fgetcsv($file);
            }
            
            fclose($file);
        }
    }
    else{
        echo "File type not allowed";
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            
            #main{
                width: 100%;
            }
            
            #filecontainer{
                margin-top: 100px;
                width: 400px;
                margin-left: auto;
                margin-right: auto;
            }
            
            #optionscontainer{
                width: 450px;
                height: 100px;
                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;
                overflow: hidden;
            }
            
            input[type="radio"]{
                width: 13px;
                height: 13px;
            }
            
            .optionitem{
                float: left;
            }
        </style>
    </head>
    <body>
        <div id="main">
            <form action="publicationsreport.php" method="POST" enctype="multipart/form-data">
                <div id="filecontainer">
                    <label for="file">Filename:</label>
                    <input type="file" name="file" id="file">
                    <input type="submit" name="submit" value="submit">
                </div>
                <div id="optionscontainer">
                    <label class="optionitem">Select an option: </label>
                    <input class="optionitem" type="radio" name="filetype" value="name">
                    <label class="optionitem">Last name, first name CSV file.</label>
                    <input class="optionitem" type="radio" name="filetype" value="netid">
                    <label class="optionitem">NetID only file</label>
                </div>
                <input type="hidden" name="hd" id="hd" value="1" />
            </form>
            <?php if(isset($_POST['hd'])){ ?>
            <table border="1">
                <tr>
                    <td>NetID</td>
                    <td>Last name</td>
                    <td>First name</td>
                    <td>Matches</td>
                </tr>
                <?php for($i = 0; $i < sizeof($names); $i++){ ?>
                <?php
                    $f_name = $mysqli->real_escape_string($names[$i]['1']);
                    $l_name = $mysqli->real_escape_string($names[$i]['0']);
                    $qry = "select login_id from ppl_general_info where f_name = '$f_name' and l_name = '$l_name'";
                    $result = $mysqli->query($qry);
                    $names[$i][] = $result->num_rows;
                    if($names[$i][2] > 0){
                        $row = $result->fetch_assoc();
                        $names[$i][] = $row['login_id'];
                    }
                    else{
                        $names[$i][] = '-';
                    }
                ?>
                <tr>
                    <td>
                        <?php echo $names[$i][3]; ?>
                    </td>
                    <td>
                        <?php echo $names[$i][0]; ?>
                    </td>
                    <td>
                        <?php echo $names[$i][1]; ?>
                    </td>
                    <td>
                        <?php echo $names[$i][2]; ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php } ?>
        </div>
    </body>
</html>