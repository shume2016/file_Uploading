

<?php
		$output_dir = "/var/www/html/uploads/";
		$con = mysql_connect('localhost', 'root', '911929223') or die(mysql_error());
		$db = mysql_select_db('upload', $con) or die(mysql_error());
		if(isset($_FILES["file"]))
      {
				$ret = array();
				$error =$_FILES["file"]["error"];
       if(strlen($_FILES["file"]["name"]) > 20){// long file name validation
				 echo"Please adjust your file name length";
				 return true;
		   	 }
			 if($_FILES["file"]["size"] > 20000000){//big siz file validation
					echo"please adjust file size";
					return true;
			  	}
				if(!is_array($_FILES["file"]["name"])) //used to upload single file
				{
			 	 	$fileName = $_FILES["file"]["name"];
					$tmpName = $_FILES["file"]["tmp_name"];
			    $fileSize = $_FILES["file"]["size"];
			    $fileType = $_FILES["file"]["type"];
					$fileType = (get_magic_quotes_gpc() == 0 ? mysql_real_escape_string($_FILES["file"]["type"]) : mysql_real_escape_string(stripslashes($_FILES["file"])));
			    $fp = fopen($tmpName, 'r');
			    $content = fread($fp, filesize($tmpName));
			    $content = addslashes($content);
			    fclose($fp);
				//	echo "file size check:".$fileSize;
			    if (!get_magic_quotes_gpc()) {
			        $fileName = addslashes($fileName);
			        }

			      move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir.$fileName);
				  	$ret[]= $fileName;
						$sql = "INSERT INTO file(File,size,Type,content) VALUES('$fileName','$fileSize','$fileType','$content')";
				    mysql_query($sql) or die(mysql_error());
						//used upload Multiple files, file[] in to the server
				     }
						else
						{
						  $fileCount = count($_FILES["file"]["name"]);
						  for($i=0; $i < $fileCount; $i++)
								  {
						  	  $fileName = $_FILES["file"]["name"][$i];
							    move_uploaded_file($_FILES["file"]["tmp_name"][$i],$output_dir.$fileName);
						  	  $ret[]= $fileName;
						       }
									 echo "Right uploaded";
			        echo json_encode($ret);
			        }
						}
 ?>
