<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RushIdle-Register</title>
    <link rel="stylesheet" href="project.css">
</head>
<body>
    <div class="windows">
    <form action="register.php" method="post">
        <table>
            <tr>
                <td>
                    Username
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
            <tr>
                <td>
                    Repeat Password
                </td>
                <td>
                    <input type="password" name="rep_pass" size="25" id="rep_pass">
                </td>
            </tr>
        </table>
        <p>Choose your class:<br>
        <input type="radio" id="warrior" name="class" value="warrior">
        <label for="warrior">Warrior</label><br>
        <input type="radio" id="rogue" name="class" value="rogue">
        <label for="rogue">Rogue</label><br>
        <input type="radio" id="berserker" name="class" value="berserker">
        <label for="mage">berserker</label></p>
        <p>EULA</p>
        <input type="checkbox" id="eula" name="eula" value="eula">
        <label for="eula">I accept the EULA</label><br>
    <button type="submit" value="register" name="register1">Register</button>
    <?php
    session_start();


    if(isset($_POST["register1"])) {

    if(empty($_POST["login"])) {
      echo "<p>please specify your username</p>";
    }
    else if(empty($_POST["password"])) {
      echo "<p>you need to set your password</p>";
    }
    else if(preg_match('/^[a-zA-z]{5,}$/',$_POST["password"])==0) {
      echo "<p>password needs to contain at least 5 digits</p>";
    }
    else if($_POST["rep_pass"]!=$_POST["password"]) {
      echo "<p>password needs to be repeated correctly</p>";
    }
    else if(!isset($_POST["class"])) {
      echo "<p>Select your class</p>";
    }
    else if (empty($_POST["eula"])) {
      echo "<p>You need to accept the EULA</p>";
    }
    else {
            $login=$_POST["login"];
            $password=$_POST["password"];
            $rep_pass=$_POST["rep_pass"];
            $class=$_POST["class"];
            echo "<p>Login: ".$login.", Password: ".$password.", Repeated: ".$rep_pass.", Class: ".$class;

            $sql_user="select * from miniapp.user where login='".$login."';";
            $sql_password="select * from miniapp.user where password='".$password."';";
            $sql_max="select max(user_id) from miniapp.user";
            str_replace('"', "", $sql_max);
            $conn=pg_connect("host=localhost port=5432 dbname=s47203 user=s47203
            password=F2bkP6K1P");

            $select=pg_query($conn, $sql_user);
            $select2=pg_query($conn, $sql_password);
            $select_max=pg_query($conn, $sql_max);
            if(pg_num_rows($select) || pg_num_rows($select2)) {
              echo "<p>Username or password already taken.</p>";
            }
            else {
              $insert_user="insert into miniapp.user(user_id, login, password) values(".pg_fetch_result($select_max, 0, 0)."+1, '".$login."', '".$password."');";
              $insert_loc1="insert into miniapp.locations(user_id, location_name, examined) values (".pg_fetch_result($select_max, 0, 0)."+1, 'sunny_plains', '1')";
              $insert_loc2="insert into miniapp.locations(user_id, location_name, examined) values (".pg_fetch_result($select_max, 0, 0)."+1, 'hollow_forest', '1')";
              if($_POST['class']=='warrior') {
                $insert_stats="insert into miniapp.stats(user_id, hp, atk, def, lvl, exp, class) values(".pg_fetch_result($select_max, 0, 0)."+1, 10, 5, 5, 1, 0, 1, warrior);";
              }
              else if($_POST['class']=='rogue') {
                $insert_stats="insert into miniapp.stats(user_id, hp, atk, def, lvl, exp, class) values(".pg_fetch_result($select_max, 0, 0)."+1, 7, 2, 8, 1, 0, 2, rogue);";
              }
              else if($_POST['class']=='berserker') {
                $insert_stats="insert into miniapp.stats(user_id, hp, atk, def, lvl, exp, class) values(".pg_fetch_result($select_max, 0, 0)."+1, 8, 8, 2, 1, 0, 3, berserker);";
              }
              else {
                echo "<p>Select your class</p>";
              }
              $select_user=pg_query($conn, $insert_user);
              $select_stats=pg_query($conn, $insert_stats);
              $select_loc1=pg_query($conn, $insert_loc1);
              $select_loc1=pg_query($conn, $insert_loc2);
              echo "<p>Registration Successful.</p>";
            }
          }
        }

    ?>
    </form>
    </div>
    </body>
</html>
