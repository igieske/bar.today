<?php

function musicstyles_all($link) {
    // sql-запрос - выбрать все колонки из таблицы musicstyles, сортировать по id
    $query = "SELECT * FROM musicstyles ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    
    // если ошибка - стопим скрипт, что за ошибка?
    if (!$result)
        die(mysqli_error($link));
    
    // извлечение из бд
    $n = mysqli_num_rows($result);
    $musicstyles = array();
    
    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $musicstyles[] = $row;
    }
    
    return $musicstyles;
    
}

//показать конкретного фэлла
function musicstyles_get($link, $id_musicstyle) {
    // запрос
    $query = sprintf("SELECT * FROM musicstyles WHERE id=%d", (int)$id_musicstyle);
    $result = mysqli_query($link, $query);
    
    if (!$result)
        die(mysqli_error($link));
    
    $musicstyle = mysqli_fetch_assoc($result);
    
    return $musicstyle;
}

function musicstyles_new($link,
          $musicstyle
               ) {
     // убираем пробелы по бокам
          $musicstyle = trim($musicstyle);
     
     if ($musicstyle == '')
          return false;
     
     // запрос
     $t = "INSERT INTO musicstyles (
          musicstyle
               ) VALUES ('%s')";
     
     $query = sprintf($t,
          mysqli_real_escape_string($link, $musicstyle));

     $result = mysqli_query($link, $query);
     
     if (!$result)
          die(mysqli_error($link));
     
     return true;
}

function musicstyles_edit($link, $id, 
          $musicstyle) {

          $musicstyle = trim($musicstyle);
     
     $id = (int)$id;

     if ($musicstyle == '')
     return false;
     
     $sql = "UPDATE musicstyles SET 
          musicstyle='%s'          
     WHERE id='%d'";
     
     $query = sprintf($sql,
          mysqli_real_escape_string($link, $musicstyle),
     $id);
     
     $result = mysqli_query($link, $query);
     
     if (!result)
          die(mysqli_error($link));
     
     return mysqli_affected_rows($link);
}

function musicstyles_del($link, $id) {
     $id = (int)$id;
     if ($id == 0)
          return false;
     
     $query = sprintf("DELETE FROM musicstyles WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
     
     if (!$result)
          die(mysqli_error($link));
     
     return mysqli_affected_rows($link);    
}

?>