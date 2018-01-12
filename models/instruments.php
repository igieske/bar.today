<?php

function instruments_all($link) {
    // sql-запрос - выбрать все колонки из таблицы instruments, сортировать по id
    $query = "SELECT * FROM instruments ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    
    // если ошибка - стопим скрипт, что за ошибка?
    if (!$result)
        die(mysqli_error($link));
    
    // извлечение из бд
    $n = mysqli_num_rows($result);
    $instruments = array();
    
    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $instruments[] = $row;
    }
    
    return $instruments;
    
}

//показать конкретного фэлла
function instruments_get($link, $id_instrument) {
    // запрос
    $query = sprintf("SELECT * FROM instruments WHERE id=%d", (int)$id_instrument);
    $result = mysqli_query($link, $query);
    
    if (!$result)
        die(mysqli_error($link));
    
    $instrument = mysqli_fetch_assoc($result);
    
    return $instrument;
}

function instruments_new($link,
          $instrument
               ) {
     // убираем пробелы по бокам
          $instrument = trim($instrument);
     
     if ($instrument == '')
          return false;
     
     // запрос
     $t = "INSERT INTO instruments (
          instrument
               ) VALUES ('%s')";
     
     $query = sprintf($t,
          mysqli_real_escape_string($link, $instrument));

     $result = mysqli_query($link, $query);
     
     if (!$result)
          die(mysqli_error($link));
     
     return true;
}

function instruments_edit($link, $id, 
          $instrument) {

          $instrument = trim($instrument);
     
     $id = (int)$id;

     if ($instrument == '')
     return false;
     
     $sql = "UPDATE instruments SET 
          instrument='%s'          
     WHERE id='%d'";
     
     $query = sprintf($sql,
          mysqli_real_escape_string($link, $instrument),
     $id);
     
     $result = mysqli_query($link, $query);
     
     if (!result)
          die(mysqli_error($link));
     
     return mysqli_affected_rows($link);
}

function instruments_del($link, $id) {
     $id = (int)$id;
     if ($id == 0)
          return false;
     
     $query = sprintf("DELETE FROM instruments WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
     
     if (!$result)
          die(mysqli_error($link));
     
     return mysqli_affected_rows($link);    
}

?>