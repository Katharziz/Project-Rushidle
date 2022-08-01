
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RushIdle-login</title>

    <link rel="stylesheet" href="project.css">
</head>
<body>
<div class="windows">
    <form action="login.php" method="post">
        <table>
            <tr>
                <td>
                    Login
                </td>
                <td>
                    <input type="text" name="login" size="25" id="login">
                </td>
            </tr>
            <tr>
                <td>
                    Password
                </td>
                <td>
                    <input type="password" name="password" size="25" id="password">
                </td>
            </tr>
        </table>
    <p><input type="submit" value="Login"> <a href='register.php'><button type="button" value="Register">Register</button></a></p>
    <?php
    session_start();
    if(isset($_POST["login"]) && isset($_POST["password"])) {
        if(empty($_POST["login"]) || empty($_POST["password"])){
            echo "Incorrect data";
        }
        else {
        echo "<p>logging... ".$_POST["login"]." ".$_POST["password"]."</p>";
        }
        $conn=pg_connect("host=localhost port=5432 dbname=s47203 user=s47203
        password=F2bkP6K1P");
        if(!$conn) {echo "<p>Can't connect with data base.</p>";
        }
        else {
            echo "<p>Connection ok</p>";
            $sql="select * from miniapp.user";

            $select=pg_query($conn, "select * FROM miniapp.user WHERE login='".$_POST["login"]."';");
            $select2=pg_query($conn, "select * FROM miniapp.user WHERE password='".$_POST["password"]."';");
            $select3=pg_query($conn, "select stats.atk from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select4=pg_query($conn, "select stats.def from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select5=pg_query($conn, "select stats.lvl from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select6=pg_query($conn, "select stats.exp from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select7=pg_query($conn, "select stats.class from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select8=pg_query($conn, "select stats.hp from miniapp.stats natural join miniapp.user where login='".$_POST["login"]."' and password='".$_POST["password"]."';");
            $select9=pg_query($conn, "select user_id from miniapp.user where login='".$_POST["login"]."';");

            if(pg_num_rows($select)) {
              if(pg_num_rows($select2)) {
                $_SESSION['username']=$_POST['login'];
                $_SESSION['attack']=pg_fetch_result($select3, 0, 0);
                $_SESSION['defence']=pg_fetch_result($select4, 0, 0);
                $_SESSION['level']=pg_fetch_result($select5, 0, 0);
                $_SESSION['exp']=pg_fetch_result($select6, 0, 0);
                $_SESSION['class']=pg_fetch_result($select7, 0, 0);
                $_SESSION['hp']=pg_fetch_result($select8, 0, 0);
                $_SESSION['id']=pg_fetch_result($select9, 0, 0);
                echo "<p>Login Successful <a href='RushIdle.php'>Play</a></p>";
              }
              else {
                echo "Wrong password";
              }
            }
            else {
              exit('<br>This user does not exist');
            }
          }
        }
    ?>
</form>
</body>
</html>
