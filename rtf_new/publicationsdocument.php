<?php

include_once '../includes/debug.php';
include_once '../includes/db.php';

function printPublications($netID, $conn){
    
    $qry = "select concat(g.l_name, ', ', g.f_name, ' ', g.m_name) as displayname, trim(p.name) as name, p.year, s.pub_status
            from ppl_general_info g inner join ppl_publication p using(pid) inner join ppl_publication_pub_status s
                using(pub_status_id)
            where login_id = '" . $conn->real_escape_string($netID) . "'";
    
    if(!$result = $conn->query($qry)){
        echo "Error: " . $conn->error;
        exit();
    }
    
        $row = $result->fetch_assoc();
        echo "<tr class='pub'><td colspan='3'>$netID - $row[displayname] - Publications: $result->num_rows</td></tr>";
        if($result->num_rows > 0){
            do{
                echo "<tr>";
                echo "<td>$row[name]</td>";
                echo "<td>$row[year]</td>";
                echo "<td>$row[pub_status]</td>";
                echo "</tr>";
            }while($row = $result->fetch_assoc());
        }
}

function printPresentations($netID, $conn){
    $qry = "select concat(g.l_name, ', ', g.f_name, ' ', g.m_name) as displayname, trim(p.name) as name, p.s_date
            from ppl_general_info g inner join ppl_presentation_project p using(pid)
                where login_id = '" . $conn->real_escape_string($netID) . "'";
    
    if(!$result = $conn->query($qry)){
        echo "Error: " . $conn->error;
        exit();
    }
    
        $row = $result->fetch_assoc();
        echo "<tr class='proj'><td colspan='3'>$netID - $row[displayname] - Presentation/Projects: $result->num_rows</td></tr>";
        if($result->num_rows > 0){
            do{
                echo "<tr>";
                echo "<td>$row[name]</td>";
                echo "<td colspan='2'>$row[s_date]</td>";
                echo "</tr>";
            }while($row = $result->fetch_assoc());
        }
}

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
            echo "Lines readen: " . sizeof($names) . "<br />";
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
            #tblReport td{
                border: 1px solid black;
            }
            
            .pub td{
                background-color: #0000FF;
                color: white;
            }
            
            .proj td{
                background-color: #008000;
                color: white;
            }
        </style>
    </head>
    <body>
        <form action="publicationsdocument.php" method="POST" enctype="multipart/form-data">
            <div id="filecontainer">
                <label for="file">Filename:</label>
                <input type="file" name="file" id="file">
                <input type="submit" name="submit" value="submit">
            </div>
            <input type="hidden" id="hd" name="hd" value="0" />
        </form>
        <?php if(isset($_POST['hd'])){ ?>
            <table id="tblReport">
                <?php for($i = 0; $i < sizeof($names); $i++){
                    printPublications($names[$i][0], $mysqli);
                    printPresentations($names[$i][0], $mysqli);
                } ?>
            </table>
        <?php } ?>
    </body>
</html>