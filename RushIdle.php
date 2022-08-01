<?php
@session_start();
json_encode($_SESSION);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>miniApp</title>

    <link rel="stylesheet" href="game.css">
    <script src="https://kit.fontawesome.com/3f3278d0bd.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
  <!--<script src="game.js" defer></script>-->
  <!--HORIZONTAL MENU-->
  <div class="menu">
    <ul class="menu_ul">
      <li class="menu_li"><a class="menu_a" id="home" onclick="mainmenu()">Main Menu</a></li>
      <li class="menu_li"><a class="menu_a" id="options" onclick="options()">Options</a></li>
      <li class="menu_li"><a class="menu_a" id="region" onclick="region()">Region</a></li>
      <li class="menu_li"><a class="menu_a" id="leaderboard" onclick="leaderboard()">Leaderboard</a></li>
    </ul>
  </div>
  <!--SIDEBAR-->
  <div class="sidebar">
    <img class="side_img" src="avatars/def_avatar.jpg" alt="user_IMG" height="150" width="150">
    <?php
    if(isset($_SESSION['username'])) {
      echo "<p>User: ".$_SESSION['username']."</p>";
      $user = $_SESSION['username'];
      $attack = $_SESSION['attack'];
      $defence = $_SESSION['defence'];
      $level = $_SESSION['level'];
      $exp = $_SESSION['exp'];
      $class = $_SESSION['class'];
      $hp = $_SESSION['hp'];
      function leadertable() {
        $sql = 'select miniapp.user.login, miniapp.stats.hp, miniapp.stats.atk, miniapp.stats.def, miniapp.stats.lvl, miniapp.stats.class
        from miniapp.user natural join miniapp.stats;';
        $select = pg_query(pg_connect("host=localhost port=5432 dbname=s47203 user=s47203 password=F2bkP6K1P"),$sql);
        $pos = pg_NumRows($select);
        echo "<table><tr><td>NAME</td><td>HP</td><td>ATTACK</td><td>DEFENSE</td><td>LEVEL</td><td>CLASS</td></tr>";
        for ($i=0; $i<$pos; $i++){
          $row= pg_fetch_array($select, $i);
          echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td></tr>";
        }
        echo "</table>";
      }
      function loc() {
        $li_class="menu_li";
        $a_class="menu_a";
        $a_id1="sun";
        $a_id2="for";
        $a_onclick1="sunnyplains()";
        $a_onclick2="hollowforest()";
        $ul_class="menu_ul";
        $sql_loc = "select miniapp.locations.examined from miniapp.user natural join miniapp.locations where login='".$_SESSION['username']."' AND miniapp.locations.location_name='hollow_forest';";
        $select_loc = pg_query(pg_connect("host=localhost port=5432 dbname=s47203 user=s47203 password=F2bkP6K1P"),$sql_loc);
        $examined = pg_fetch_result($select_loc, 0, 0);

        if($examined==1) {
          echo "<ul class=".trim($ul_class, '"')."><li class=".trim($li_class, '"')."><a class=".trim($a_class, '"')." id=".trim($a_id1, '"')." onclick=".trim($a_onclick1, '"').">Sunny Plains</a></li><li class=".trim($li_class, '"')."><a class=".trim($a_class, '"')." id=".trim($a_id2, '"')." onclick=".trim($a_onclick2, '"').">Hollow Forest</a></li></ul>";
        }
        else {
          echo "<ul class=".trim($ul_class, '"')."><li class=".trim($li_class, '"')."><a class=".trim($a_class, '"')." onclick=".trim($a_onclick1, '"').">Sunny Plains</a></li></ul>";
        }
      }
      $sql_monster = 'select * from miniapp.monsters';
      $select_monster = pg_query(pg_connect("host=localhost port=5432 dbname=s47203 user=s47203 password=F2bkP6K1P"),$sql_monster);
      $slime = array (pg_fetch_result($select_monster, 0, 2), pg_fetch_result($select_monster, 0, 3), pg_fetch_result($select_monster, 0, 4), pg_fetch_result($select_monster, 0, 5));
      $rat = array (pg_fetch_result($select_monster, 1, 2), pg_fetch_result($select_monster, 1, 3), pg_fetch_result($select_monster, 1, 4), pg_fetch_result($select_monster, 1, 5));
      $militia = array (pg_fetch_result($select_monster, 2, 2), pg_fetch_result($select_monster, 2, 3), pg_fetch_result($select_monster, 2, 4), pg_fetch_result($select_monster, 2, 5));
      $goblin = array (pg_fetch_result($select_monster, 3, 2), pg_fetch_result($select_monster, 3, 3), pg_fetch_result($select_monster, 3, 4), pg_fetch_result($select_monster, 3, 5));
      $goblin_archer = array (pg_fetch_result($select_monster, 4, 2), pg_fetch_result($select_monster, 4, 3), pg_fetch_result($select_monster, 4, 4), pg_fetch_result($select_monster, 4, 5));
      $goblin_chief = array (pg_fetch_result($select_monster, 5, 2), pg_fetch_result($select_monster, 5, 3), pg_fetch_result($select_monster, 5, 4), pg_fetch_result($select_monster, 5, 5));
    }
    else error_reporting(E_ALL);
    ?>
    <!--VARIABLES-->
    <script type="text/javascript">
    let user = '<?php echo $user; ?>';
    let attack = ~~'<?php echo $attack; ?>';
    let defence = ~~'<?php echo $defence; ?>';
    let level = ~~'<?php echo $level; ?>';
    let exp = ~~'<?php echo $exp; ?>';
    let cls = '<?php echo $class; ?>';
    let hpmax = ~~'<?php echo $hp; ?>';
    let hp = ~~'<?php echo $hp; ?>';
    let leadertable = '<?php echo leadertable(); ?>';
    let loc = '<?php echo loc(); ?>';



    //MONSTER STATISTICS
    let monsters = [
      ["monsters/slime.png", "Slime", ~~'<?php echo array_values($slime)[0]; ?>', ~~'<?php echo array_values($slime)[0]; ?>', ~~'<?php echo array_values($slime)[1]; ?>',
          ~~'<?php echo array_values($slime)[2]; ?>', ~~'<?php echo array_values($slime)[3]; ?>'],
      ["monsters/rat.jpeg", "Rat", ~~'<?php echo array_values($rat)[0]; ?>', ~~'<?php echo array_values($rat)[0]; ?>', ~~'<?php echo array_values($rat)[1]; ?>',
        ~~'<?php echo array_values($rat)[2]; ?>', ~~'<?php echo array_values($rat)[3]; ?>'],
      ["monsters/militia.png", "Militia", ~~'<?php echo array_values($militia)[0]; ?>', ~~'<?php echo array_values($militia)[0]; ?>', ~~'<?php echo array_values($militia)[1]; ?>',
          ~~'<?php echo array_values($militia)[2]; ?>', ~~'<?php echo array_values($militia)[3]; ?>'],
      ["monsters/goblin.jfif", "Goblin", ~~'<?php echo array_values($goblin)[0]; ?>', ~~'<?php echo array_values($goblin)[0]; ?>', ~~'<?php echo array_values($goblin)[1]; ?>',
        ~~'<?php echo array_values($goblin)[2]; ?>', ~~'<?php echo array_values($goblin)[3]; ?>'],
      ["monsters/g_archer.jpg", "Goblin Archer", ~~'<?php echo array_values($goblin_archer)[0]; ?>', ~~'<?php echo array_values($goblin_archer)[0]; ?>', ~~'<?php echo array_values($goblin_archer)[1]; ?>',
        ~~'<?php echo array_values($goblin_archer)[2]; ?>', ~~'<?php echo array_values($goblin_archer)[3]; ?>'],
      ["monsters/g_chief.jpg", "Goblin Chief", ~~'<?php echo array_values($goblin_chief)[0]; ?>', ~~'<?php echo array_values($goblin_chief)[0]; ?>', ~~'<?php echo array_values($goblin_chief)[1]; ?>',
        ~~'<?php echo array_values($goblin_chief)[2]; ?>', ~~'<?php echo array_values($goblin_chief)[3]; ?>']
    ];

    let slime_img = "monsters/slime.png";
    let slime_alt ="Slime";
    let slime_hp = ~~'<?php echo array_values($slime)[0]; ?>';
    let slime_hpmax = ~~'<?php echo array_values($slime)[0]; ?>';
    let slime_atk = ~~'<?php echo array_values($slime)[1]; ?>';
    let slime_def = ~~'<?php echo array_values($slime)[2]; ?>';
    let slime_exp = ~~'<?php echo array_values($slime)[3]; ?>';

    let goblin_img = "monsters/goblin.jfif";
    let goblin_alt = "Goblin";
    let goblin_hp = ~~'<?php echo array_values($goblin)[0]; ?>';
    let goblin_hpmax = ~~'<?php echo array_values($goblin)[0]; ?>';
    let goblin_atk = ~~'<?php echo array_values($goblin)[1]; ?>';
    let goblin_def = ~~'<?php echo array_values($goblin)[2]; ?>';
    let goblin_exp = ~~'<?php echo array_values($goblin)[3]; ?>';

    </script>
    <p id="sidelevel"></p>
    <p id="hp"></p>
    <ul class="sidebar_ul">
      <li class="sidebar_li" id="atk"></li>
      <li class="sidebar_li" id="def"></li>
    </ul>
    <p id="exp"></p>
  </div>



  <ul class="game">
      <li><div class="content" id="content">
        <h2>WELCOME TO RUSHIDLE</h2>
        <p>Here are some quick instructions, what everything does.</p>
        <p>On your left is your panel about your character, your HP, attack and defence.<br>
        On your left down corner you have save button that will save your progress automatically
        every 30min.</p>
        <p>Options - configure your profile and see your statistics</p>
        <p>Region - choose your region where you want to fight. If you kill 5 slimes, you get to next location!</p>
        <p>Leaderboard - see how you look among other players!</p>
        <p>Contact - use only if you have a problem or see a bug to contact the developer</p>
        <!--JAVASCRIPT-->
        <script type="text/javascript">
        let req_exp = 0;
        if (level ==1) {
          req_exp = 5;
        }
        else if (level ==2) {
          req_exp = 25;
        }
        else {
          req_exp = 100;
        }
        document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
        document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
        document.getElementById('atk').innerHTML='ATK: '+attack;
        document.getElementById('def').innerHTML='DEF: '+defence;
        document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
        let element = document.getElementById('content');
        let img_user = "avatars/def_avatar.jpg";
        let user_alt = "avatar";
        let height = "150";
        let width = "150";
        let button = "button";
        let action_atk_for = "atkfor()";
        let action_atk_sun = "atksun()";
        let atk_id = "atk_button";
        let action_def_for = "deffor()";
        let action_def_sun = "defsun()";
        let def_id = "def_button";

        //EXP
        let expbar = document.getElementById('exp');
        //TABS
        function mainmenu() {
          element.style.backgroundImage = "url()";
          document.getElementById('content').innerHTML='<h2>WELCOME TO RUSHIDLE</h2><p>Here are some quick instructions, what everything does.</p><p>On your left is your panel about your character, your HP, attack and defence.<br>On your left down corner you have save button that will save your progress automatically every 30min.</p><p>Options - configure your profile and see your statistics</p><p>Region - choose your region where you want to fight. If you kill 5 slimes, you get to next location!</p><p>Leaderboard - see how you look among other players!<p><p>Contact - use only if you have a problem or see a bug to contact the developer</p>;';
        }
        function options() {
          let post = "post";
          let send = "send.php";
          let submit = "submit";
          let sub_user = "login";
          let sub_hpmax = "sub_hp";
          let sub_attack = "sub_atk";
          let sub_defence = "sub_def";
          let sub_level = "sub_lvl";
          let sub_exp = "sub_exp";

          element.style.backgroundImage = "url()";
          document.getElementById('content').innerHTML='<h2>OPTIONS</h2><img src="avatars/def_avatar.jpg" alt="user_IMG" height="150" width="150"><p>User: '+user+'</p><p>Your maximum hitpoints: '+hpmax+'</p><p>Your attack: '+attack+'</p><p>Your defence: '+defence+'</p><p>Your level: '+level+'</p><p>Your experience: '+exp+'</p><p>Your class: '+cls+'</p>';
          document.getElementById('content').innerHTML+='<form action='+send+' method='+post+'><textarea readonly name='+sub_user+'>'+user+'</textarea><textarea readonly name='+sub_hpmax+'>'+hpmax+'</textarea><textarea readonly name='+sub_attack+'>'+attack+'</textarea><textarea readonly name='+sub_defence+'>'+defence+'</textarea><textarea readonly name='+sub_level+'>'+level+'</textarea><textarea readonly name='+sub_exp+'>'+exp+'</textarea><button type='+submit+'>SAVE</button></form>';
        }
        function region() {
          element.style.backgroundImage = "url()";
          document.getElementById('content').innerHTML='<h2>CHOOSE YOUR LOCATION</h2>'+loc;
        }
        function leaderboard() {
          element.style.backgroundImage = "url()";
          document.getElementById('content').innerHTML='<h2>LEADERBOARD</h2>'+leadertable;
        }
        function contact() {
          element.style.backgroundImage = "url()";
          document.getElementById('content').innerHTML='<h2>CONTACT</h2>'+loc;
        }
        let oppfor=Math.floor(Math.random()*5)+2;
        let oppsun=Math.floor(Math.random()*2)+0;
        function sunnyplains() {
          element.style.backgroundImage = "url('locations/plains.png')";
          element.innerHTML="<h2>SUNNY PLAINS</h2>";
          document.getElementById('console').innerHTML += "<p>You enter Sunny Plains.</p>";
          const waiter = setTimeout(function() {
            searchsun()
          }, 2000);
           function searchsun() {
             let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+slime_img+" alt="+slime_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+slime_hp+"/"+slime_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+slime_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+slime_def+"</td></tr></table>";
             document.getElementById('console').innerHTML += "<p>You encounter: A SLIME!</p>";
             element.innerHTML+=form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
           }
        }
        function hollowforest() {
          element.style.backgroundImage = "url('locations/forest.jpg')";
          element.innerHTML='<h2>HOLLOW FOREST</h2>';
          document.getElementById('console').innerHTML += "<p>You enter Hollow Forest.</p>";
          const waiter = setTimeout(function() {
            searchfor()
          }, 2000);
           function searchfor() {
             let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+goblin_img+" alt="+goblin_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+goblin_hp+"/"+goblin_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+goblin_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+goblin_def+"</td></tr></table>";
             document.getElementById('console').innerHTML += "<p>You encounter: A GOBLIN!</p>";
             element.innerHTML+=form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
           }
        }

        //============COMBAT
        function atkfor() {
          let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+goblin_img+" alt="+goblin_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+goblin_hp+"/"+goblin_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+goblin_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+goblin_def+"</td></tr></table>";
          let atk_chance = 50 + 10*(attack-goblin_def);
          let def_chance = 50 + 10*(defence-goblin_atk);


          if (atk_chance >= Math.random() * 101) {
            goblin_hp-=1;
            document.getElementById('console').innerHTML += "<p>HIT! You deal 1 damage to Goblin.</p>";
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            document.getElementById('console').innerHTML += "<p>You Miss!</p>";
          }
          if (def_chance <= Math.random() * 101) {
            hp-=1;
            document.getElementById('console').innerHTML += "<p>Enemy deals to you 1 damage.</p>";
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            document.getElementById('console').innerHTML += "<p>Goblin misses!</p>";
          }


          if (goblin_hp<=0) {
            document.getElementById('console').innerHTML += "<p>YOU WIN! Earned "+goblin_exp+"EXP</p>";
            hp = hpmax;
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
            exp=exp+goblin_exp;
            goblin_hp = goblin_hpmax;
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
            if (exp >= req_exp) {
              exp=0;
              level++;
              if (level ==1) {
                req_exp = 5;
              }
              else if (level ==2) {
                req_exp = 25;
              }
              else {
                req_exp = 100;
              }
              attack++;
              defence++;
              hpmax++;
              document.getElementById('console').innerHTML += "<p>LEVEL UP! You're now level "+level+"</p>";
              document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
              document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
              document.getElementById('atk').innerHTML='ATK: '+attack;
              document.getElementById('def').innerHTML='DEF: '+defence;
              document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
            }
          }
          else if (hp==0) {
            document.getElementById('console').innerHTML += "<p>YOU LOST!</p>";

            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
            hp = hpmax;
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }





        }


        function deffor() {
          let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+goblin_img+" alt="+goblin_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+goblin_hp+"/"+goblin_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+goblin_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+goblin_def+"</td></tr></table>";
          let def_chance = 75 + 10*(defence-goblin_atk);
          let counter = 25 + 10*(defence-goblin_atk);;

          if (def_chance <= Math.random() * 101) {
            hp-=1;
            document.getElementById('console').innerHTML += "<p>You failed to defend yourself! Enemy deals to you 1 damage.</p>";
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            if (def_chance >= Math.random() * 101) {
              if (counter >= Math.random() * 101) {
              goblin_hp-=2;
              document.getElementById('console').innerHTML += "<p>You managed to counter the Goblin! You dealt 2 damage.</p>";
              element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
              if (goblin_hp<=0) {
                document.getElementById('console').innerHTML += "<p>YOU WIN! Earned "+goblin_exp+"EXP</p>";
                hp = hpmax;
                element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
                exp=exp+goblin_exp;
                goblin_hp = goblin_hpmax;
                document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
                document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
                document.getElementById('atk').innerHTML='ATK: '+attack;
                document.getElementById('def').innerHTML='DEF: '+defence;
                document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
                if (exp >= req_exp) {
                  exp=0;
                  level++;
                  if (level ==1) {
                    req_exp = 5;
                  }
                  else if (level ==2) {
                    req_exp = 25;
                  }
                  else {
                    req_exp = 100;
                  }
                  attack++;
                  defence++;
                  hpmax++;
                  document.getElementById('console').innerHTML += "<p>LEVEL UP! You're now level "+level+"</p>";
                  document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
                  document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
                  document.getElementById('atk').innerHTML='ATK: '+attack;
                  document.getElementById('def').innerHTML='DEF: '+defence;
                  document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
                }
                element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
              }
            }
            else {
              document.getElementById('console').innerHTML += "<p>Succesfully Blocked!</p>";
              element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_for+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_for+">DEFEND</button></td></tr></table>";
            }
          }
        }
      }






        function atksun() {
          let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+slime_img+" alt="+slime_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+slime_hp+"/"+slime_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+slime_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+slime_def+"</td></tr></table>";
          let atk_chance = 50 + 10*(attack-slime_def);
          let def_chance = 50 + 10*(defence-slime_atk);


          if (atk_chance >= Math.random() * 101) {
            slime_hp-=1;
            document.getElementById('console').innerHTML += "<p>HIT! You deal 1 damage to Goblin.</p>";
            document.getElementById('content')=='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            document.getElementById('console').innerHTML += "<p>You Miss!</p>";
            document.getElementById('content')=='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
          }
          if (def_chance <= Math.random() * 101) {
            hp-=1;
            document.getElementById('console').innerHTML += "<p>Enemy deals to you 1 damage.</p>";
            document.getElementById('content')=='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            document.getElementById('console').innerHTML += "<p>Slime misses!</p>";
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
          }


          if (slime_hp==0) {
            document.getElementById('console').innerHTML += "<p>YOU WIN! Earned "+slime_exp+"EXP</p>";
            hp = hpmax;
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
            exp=exp+slime_exp;
            slime_hp = slime_hpmax;
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
            if (exp >= req_exp) {
              exp=0;
              level++;
              if (level ==1) {
                req_exp = 5;
              }
              else if (level ==2) {
                req_exp = 25;
              }
              else {
                req_exp = 100;
              }
              attack++;
              defence++;
              hpmax++;
              document.getElementById('console').innerHTML += "<p>LEVEL UP! You're now level "+level+"</p>";
              document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
              document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
              document.getElementById('atk').innerHTML='ATK: '+attack;
              document.getElementById('def').innerHTML='DEF: '+defence;
              document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
            }
          }
          else if (hp==0) {
            document.getElementById('console').innerHTML += "<p>YOU LOST!</p>";

            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
            hp = hpmax;
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          document.getElementById('content')=='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
        }

        function defsun() {
          let form = "<table><tr><td><img src="+img_user+" alt="+user_alt+" height="+height+" width="+width+"></td><td><img src="+slime_img+" alt="+slime_alt+" height="+height+" width="+width+"></td></tr><tr><td>HP:"+hp+"/"+hpmax+"</td><td>HP:"+slime_hp+"/"+slime_hpmax+"</td></tr><tr><td>ATK: "+attack+"</td><td>ATK:"+slime_atk+"</td></tr><tr><td>DEF: "+defence+"</td><td>DEF: "+slime_def+"</td></tr></table>";
          let def_chance = 75 + 10*(defence-slime_atk);
          let counter = 25 + 10*(defence-slime_atk);;

          if (def_chance <= Math.random() * 101) {
            hp-=1;
            document.getElementById('console').innerHTML += "<p>You failed to defend yourself! Enemy deals to you 1 damage.</p>";
            element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
            document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
            document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
            document.getElementById('atk').innerHTML='ATK: '+attack;
            document.getElementById('def').innerHTML='DEF: '+defence;
            document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
          }
          else {
            if (def_chance >= Math.random() * 101) {
              if (counter >= Math.random() * 101) {
              slime_hp-=2;
              document.getElementById('console').innerHTML += "<p>You managed to counter the Goblin! You dealt 2 damage.</p>";
              element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
              if (slime_hp<=0) {
                document.getElementById('console').innerHTML += "<p>YOU WIN! Earned "+slime_exp+"EXP</p>";
                hp = hpmax;
                element.innerHTML='<h2>HOLLOW FOREST</h2>'+form;
                exp=exp+slime_exp;
                slime_hp = slime_hpmax;
                document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
                document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
                document.getElementById('atk').innerHTML='ATK: '+attack;
                document.getElementById('def').innerHTML='DEF: '+defence;
                document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
                if (exp >= req_exp) {
                  exp=0;
                  level++;
                  if (level ==1) {
                    req_exp = 5;
                  }
                  else if (level ==2) {
                    req_exp = 25;
                  }
                  else {
                    req_exp = 100;
                  }
                  attack++;
                  defence++;
                  hpmax++;
                  document.getElementById('console').innerHTML += "<p>LEVEL UP! You're now level "+level+"</p>";
                  document.getElementById('sidelevel').innerHTML='LEVEL: '+level;
                  document.getElementById('hp').innerHTML='HP:<br>'+hp+'/'+hpmax;
                  document.getElementById('atk').innerHTML='ATK: '+attack;
                  document.getElementById('def').innerHTML='DEF: '+defence;
                  document.getElementById('exp').innerHTML='EXP: '+exp+"/"+req_exp;
                }
              }
            }
            else {
              document.getElementById('console').innerHTML += "<p>Succesfully Blocked!</p>";
              element.innerHTML='<h2>HOLLOW FOREST</h2>'+form+"<table><tr><td><button type="+button+" id="+atk_id+" onclick="+action_atk_sun+">ATTACK</button></td><td><button type="+button+" id="+def_id+" onclick="+action_def_sun+">DEFEND</button></td></tr></table>";
            }
          }
        }
      }

        </script>
      </div></li>

      <li><div class="console" id="console">
    </div></li>
  </ul>
</body>
</html>
