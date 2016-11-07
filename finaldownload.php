<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<title>List of Downloadable files</title>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<link rel="stylesheet" href="style_2.css" type="text/css" />
</head>
<?php
    //database connection

    $con = mysql_connect('localhost', 'root', '911929223') or die(mysql_error());
    $db = mysql_select_db('upload', $con);
    $query = "SELECT Id, File FROM file";
    $result = mysql_query($query) or die('Error, query failed');
    $query2 = mysql_fetch_array($result);
    if(mysql_num_rows($result)==0){ //setting the display
        echo "Database is empty <br>";
        }
    else{//table to display the list and the files
      echo"<table><tr><th colspan=4><h4>Downloadable file lists</h4></th></tr>";
      echo"<tr><th> Number</th><th>File lists</th><th>Delete</th></tr>";

      while(list($id, $name) = mysql_fetch_array($result)){

        echo"<tr><td>".$id."</td>";
        echo"<td><a href=finaldownload.php?id=$id>$name</a></td>";
        //echo "<td><form action='delete.php' method='post'>";
        echo "<input type='hidden' name='name' value=''>";
        //echo "<input type='submit' name='delete' value='Delete'>";
        echo "<td><a href='delete.php?id=".$query2['Id']."'>delete </a>";
        echo "</td></tr></form>";
        }
        echo "</table>";
        }
     if(isset($_GET['id'])){//Download code part
        $id    = $_GET['id'];
        $query = "SELECT * FROM file WHERE Id = '$id'";
        $result = mysql_query($query) or die('Error, query failed');
        list($tid,$name, $type, $size, $content) =  mysql_fetch_row($result);
        header("Content-Disposition: attachment; filename=$name");
        header("Content-type: $type");
        header("Content-length: $size");
        ob_clean();
        flush();
        echo $content;
        mysql_close();
     }
?>
