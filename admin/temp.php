$table = "<table class='w3-table w3-small w3-striped w3-responsive w3-bordered'>";
$table .= "<tr>
<th>Owner</th>
<th>Vehicle Number</th>
<th>Rcbook</th>
<th>Rc Book Valid From</th>
<th>Rc Book Valid Till</th>
<th>Insurance</th>
<th>Insurace Valid From</th>
<th>Insurance Valid Till</th>
</tr>";
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
  $rcpath = $row['rcbook'];
  $inpath = $row['insurance'];
  $table .= "<tr><td>".$row['owner']."</td>";
  $table .= "<td>".$row['vehicleNumber']."</td>";
  $table .= "<td>"."<a href='$rcpath'>view</a>"."</td>";
  $table .= "<td>".$row['rcfrom']."</td>";
  $table .= "<td>".$row['rctill']."</td>";
  $table .= "<td>"."<a href='$inpath'>view</a>"."</td>";
  $table .= "<td>".$row['insurancefrom']."</td>";
  $table .= "<td>".$row['insurancetill']."</td></tr>";

}
$table .= "</table>";
