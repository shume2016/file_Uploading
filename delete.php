<?php
$con = mysql_connect('localhost', 'root', '911929223') or die(mysql_error());
$db = mysql_select_db('upload', $con) or die(mysql_error());

if(isset($_GET['id']))
{
$id=$_GET['id'];
$query1=mysql_query("delete from file where id='$id'");
if($query1)
{
header('location:finaldownload.php');
echo "deleted";
}
}
?>
