<?php
$conn = mysqli_connect("localhost","root","","inition_email");
 
                            $sqlSelect = "SELECT * FROM new_email";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet'>

  
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Striped Rows</h2>
  <p>The .table-striped class adds zebra-stripes to a table:</p>            
  <table class="table table-striped" id="example">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Email</th>
        <th>Subscribe Status</th>
      </tr>
    </thead>
    <tbody>
     <?php
// echo $sqlSelect;
                            $result1 = mysqli_query($conn, $sqlSelect);
 //echo "<script>alert('".$result1."')</script>"; 
                                if (mysqli_num_rows($result1) > 0)
                                {
                                    while ($row = mysqli_fetch_array($result1)) {
                                    	echo "<tr><td>".$row['id']."</td><td>".$row['email_id']."<td>";
                                    	echo "<td>".$row['subscribe_status']."</td></tr>";

                                  }
                                }
     ?>
    </tbody>
  </table>
</div>
  <script>
  	$(document).ready(function() {
    $('#example').DataTable();
} );
  </script>
 



</body>
</html>
