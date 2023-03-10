<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Тестовое задание</title>
    <link rel="stylesheet" href="/css/style.css" type="text/css">
  </head>
  <body">
    <form action="" method="POST">
        <input name="parse" type="submit" class="parse-button" value="Parse" />
        <input name="show" type="submit" class="show-button" value="Show" />
    </form>
  </body>
</html>


<?php
  if (isset($_POST['parse'])){functParse();}
  else if (isset($_POST['show'])){functShow();}

  function functParse(){
    $result = file_get_contents("https://api.coingecko.com/api/v3/global");
    $myArray = json_decode($result, true);
    $mysql = new mysqli("localhost", "root", "", "Test");
    $nextArray = $myArray['data']['market_cap_percentage'];
    $keysArray = array_keys($nextArray);
    $i = 1; $j = 1;
    foreach($keysArray as $key){
      $mysql->query("UPDATE `MyTable` SET `name` = '$key' WHERE `MyTable`.`id` = $j");
      $j++;
    }
    foreach($nextArray as $row){
      $mysql->query("UPDATE `MyTable` SET `value` = $row WHERE `MyTable`.`id` = $i");
      $i++;
    }
    $mysql->close();
    }

  function functShow(){
    $mysql = new mysqli("localhost", "root", "", "Test");
    $result = $mysql->query("SELECT * FROM `MyTable`");
    echo '<br>'.'<center><table>'.'<tr>'.'<td>'.'ID'.'</td>'.'<td>'.'Значение'.'</td>'.'</tr>';
    while($row = $result->fetch_assoc()){
      echo '<tr>'.'<td>'.$row['name'].'</td>'.'<td>'.$row['value'].'</td>'.'</tr>';
    }
    echo '</center></table>';
    $mysql->close();
  }
?>
