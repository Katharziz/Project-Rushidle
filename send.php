<?php
@session_start();
$conn=pg_connect("host=localhost port=5432 dbname=s47203 user=s47203
password=F2bkP6K1P");
$sql="update miniapp.stats set hp='".$_POST['sub_hp']."', atk='".$_POST['sub_atk']."', def='".$_POST['sub_def']."', lvl='".$_POST['sub_lvl']."', exp='".$_POST['sub_exp']."' where user_id='".$_SESSION['id']."';";

$select=pg_query($conn, $sql);


$sql2="select * from miniapp.stats";
$select2=pg_query($conn, $sql2);

if (!$select2)
{
print "błąd w dostępie do tabeli partie";
exit;
}
$Pos=pg_NumRows($select2);
echo "<h1>SUCCESSFULLY SAVED</h1>";
echo "<table><tr><td>USER ID</td><td>HP</td><td>ATK</td><td>DEF</td><td>LVL</td><td>EXP</td><td>CLASS</td></tr>";
for ($i=0; $i<$Pos; $i++){
  $row= pg_fetch_array($select2, $i);
  echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";
}
echo "</table>";
echo '<a href="https://foka.umg.edu.pl/~s47203/Technologie%20Informacyjne/RushIdle/login.php">GO BACK</a>';
session_destroy();
?>
