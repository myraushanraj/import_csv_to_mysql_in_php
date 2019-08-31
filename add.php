<?php
error_reporting(0);

function generateRandomString($char) {
    $length = 20;
    $characters = $char.date();
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$conn = mysqli_connect("localhost","root","","inition_email");
require_once('vendor/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        $message='';
        $sheetCount = count($Reader->sheets());
        $inserted_count=0;
        $duplicate_count=0;
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
           
            foreach ($Reader as $Row)
            {
          
                $name = "";
                if(isset($Row[0])) {
                    $name = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                
                
                if (!empty($name)) {
                    
                    $token=generateRandomString($name);

                    $insertquery = "insert into new_email(email_id,unsubscribe_token) values('".$name."','".$token."')";
                            $sqlSelect = "SELECT * FROM new_email where email_id='$name'";
                           // echo $sqlSelect;
                            $result1 = mysqli_query($conn, $sqlSelect);
 //echo "<script>alert('".$result1."')</script>"; 
                                if (mysqli_num_rows($result1) > 0)
                                {
                                    while ($row = mysqli_fetch_array($result1)) {
                                         // echo "<p style='color:red'>geting duplicate email-".$row['email_id']."</p>";  
                                          $duplicate_count+=1;
                                    }
                              
                                }
                                else{

                                     $result = mysqli_query($conn, $insertquery);
                                     $inserted_count+=1;
                                }

                   
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data (".$inserted_count.") Imported into the Database. Duplicate record=".$duplicate_count;
                        
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data or record is duplicate";
                    }
                }
             }

         }
        echo "<script>alert('".$message."')</script>";


  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>

<!DOCTYPE html>
<html>    
<head>
<style>    
body {
	font-family: Arial;
	background: turquoise;

}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
        width:550px;
        margin:125px auto;
        margin-bottom:2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
</head>

<body>
    <div style="width:100%">
    
    
    <div class="outer-container">
        <h2 style="text-align:center">Import Excel File into MySQL Database</h2>
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         
</div>

</body>
</html>