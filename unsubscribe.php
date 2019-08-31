<?php
$conn = mysqli_connect("localhost","root","","inition_email");
if(isset($_GET['token'])){
  $token=$_GET['token'];

  $sqlSelect = "SELECT * FROM new_email where unsubscribe_token='$token'";
                           // echo $sqlSelect;
                            $result1 = mysqli_query($conn, $sqlSelect);
 //echo "<script>alert('".$result1."')</script>"; 
                                if (mysqli_num_rows($result1) > 0)
                                {
                                    while ($row = mysqli_fetch_array($result1)) {
                                      echo "<p>Email is-  ".$row['email_id']."</p>";

                                        $sqlUpdate = "UPDATE new_email SET `subscribe_status`=0 where `unsubscribe_token`='$token'";
                                       // echo $sqlUpdate;
                                        $result2 = mysqli_query($conn, $sqlUpdate);
                                        if($result2){
                                          echo "<p>Unsubscribe successfully!</p>";
                                        }
                                        else{
                                           echo "<p>Something went wrong!</p>"; 
                                        }

                                  }
                                }
                                else{
                                  echo "<p>Invalid token</p>";
                                }
}
else{
echo "<p>Token not found</p>";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    body{
      background:gray;
    }
  p{
    text-align: center;
    color: green;
    margin: 120px;
    background: skyblue;
    padding:20px;
    font-size: 16px;
}
</style>
</head>
<body>

<div class="container">
             
 
</div>

</body>
</html>
