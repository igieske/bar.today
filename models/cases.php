<?php

function cases_all($link) {
     $query = "SELECT * FROM cases ORDER BY date DESC";
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $n = mysqli_num_rows($result);
     $cases = array();

     for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $cases[] = $row;
     }
     return $cases;
}

function cases_get($link, $id_case) {
     $query = sprintf("SELECT * FROM cases WHERE id=%d", (int)$id_case);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $case = mysqli_fetch_assoc($result);
     return $case;
}

function cases_new($link,
     $case_type,
     $title,
     $motto,
     $description_brief,
     $description,
     $date,
     $one_day_or,
     $start_time,
     $entry_price,
     $bar_id,
     $input_fellas,
     $input_bands) {

     $title = trim($title);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $one_day_or = trim($one_day_or);
     $entry_price = trim($entry_price);
     $bar_id = trim($bar_id);
     
     if ($case_type == '') return false;
     if ($entry_price == '') $entry_price = 'NULL';
     if ($start_time == '') $start_time = 'NULL';
          else $start_time = '"'.mysqli_real_escape_string($link, $start_time).'"';

     $t = "INSERT INTO cases (

          case_type,
          title,
          motto,
          description_brief,
          description,
          date,
          one_day_or,
          start_time,
          entry_price,
          bar_id ) VALUES (

          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          $start_time,
          $entry_price,
          '%s')";
     
     $query = sprintf($t,
          mysqli_real_escape_string($link, $case_type),
          mysqli_real_escape_string($link, $title),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $date),
          mysqli_real_escape_string($link, $one_day_or),
          mysqli_real_escape_string($link, $bar_id));

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     // создаём связи в link_cases_f_b
     $case_id = mysqli_insert_id($link);

     if ($input_fellas != '') {
          for ($i = 0; $i < count($input_fellas); $i++) {
               $input_fella = $input_fellas[$i];
               $u = "INSERT INTO link_cases_f_b (case_id, fella_id) VALUES (
                    $case_id, $input_fella)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }
     if ($input_bands != '') {
          for ($i = 0; $i < count($input_bands); $i++) {
               $input_band = $input_bands[$i];
               $u = "INSERT INTO link_cases_f_b (case_id, band_id) VALUES (
                    $case_id, $input_band)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }

     return true;
}

function cases_edit($link, $id, 
     $case_type,
     $title,
     $motto,
     $description_brief,
     $description,
     $date,
     $one_day_or,
     $start_time,
     $entry_price,
     $bar_id,
     $input_fellas,
     $input_bands) {

     $title = trim($title);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $one_day_or = trim($one_day_or);
     $entry_price = trim($entry_price);
     $bar_id = trim($bar_id);

     $id = (int)$id;

     if ($case_type == '') return false;
     if ($entry_price == '') $entry_price = 'NULL';
     if ($start_time == '') $start_time = 'NULL';
          else $start_time = '"'.mysqli_real_escape_string($link, $start_time).'"';

     $sql = "UPDATE cases SET 
          case_type='%s',
          title='%s',
          motto='%s',
          description_brief='%s',
          description='%s',
          date='%s',
          one_day_or='%s',
          start_time=$start_time,
          entry_price=$entry_price,
          bar_id='%s'

          WHERE id='%d'";

     $query = sprintf($sql,
          mysqli_real_escape_string($link, $case_type),
          mysqli_real_escape_string($link, $title),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $date),
          mysqli_real_escape_string($link, $one_day_or),
          mysqli_real_escape_string($link, $bar_id),
          $id);

     $result = mysqli_query($link, $query);
          if (!result) die(mysqli_error($link));

     // обновляем связи в link_cases_f_b (для фэллас)
     addit_update_links($link, 'link_cases_f_b', 'fella_id', 'case_id', $id, $input_fellas);
     addit_update_links($link, 'link_cases_f_b', 'band_id', 'case_id', $id, $input_bands);
     
     return mysqli_affected_rows($link);
}

function cases_del($link, $id) {
     $id = (int)$id;
     if ($id == 0) return false;
     
     $query = sprintf("DELETE FROM cases WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return mysqli_affected_rows($link);
}

?>