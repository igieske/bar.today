<?php

date_default_timezone_set('Europe/Moscow');

// если админ, добавляем в начало ссылки путь к корню сайта
function admin_url_home() {
     if (function_exists('idkfa')) return '../';
}

// если админ - кнопочка "add" в админке
function admin_item_add($item) {
     if (function_exists('idkfa')) echo
     '<span class="admin-item">
          <a href="index.php?action=add-'.$item.'">add</a>
     </span>
     ';
}
// если админ - кнопочки "edit" и "delete" в админке
function admin_item_edit($item, $id) {
     if (function_exists('idkfa')) echo
     '<span class="admin-item">
          <a href="index.php?action=edit-'.$item.'&id='.$id.'">e</a>
          <a href="index.php?action=del-'.$item.'&id='.$id.'" onclick="return confirm('."'Точно удаляем?'".')">d</a>
     </span><br>';
}

function translit($str) {
     $rus = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я');
     $lat = array('A','B','V','G','D','E','E','Gh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sch','Y','Y','Y','E','Yu','Ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya');
     return str_replace($rus, $lat, $str);
}

function redirect($path) {
     echo '<script>location.href="'.$path.'";</script>';
}

function fio($src) { // вывод: имя псевдоним фамилия
     return trim(preg_replace('| +|',' ',$src['name'].' '.$src['pseudonym'].' '.$src['last_name']));
}
function fio2($src) { // вывод: фамилия имя [псевдоним]
     if (!empty($src['pseudonym'])) $pseudonym = '['.$src['pseudonym'].']';
          else $pseudonym = '';
     return trim(preg_replace('| +|',' ',$src['last_name'].' '.$src['name'].' '.$pseudonym));
}

// путь к постерам для кейсов
function poster_path_template($data, $if_path, $if_name) {
     $year = date('y', strtotime($data['date'])); // номер года
     $month = date('m', strtotime($data['date'])); // номер месяца
     $day = date('d', strtotime($data['date'])); // номер дня
     $posters_path = 'images/cases/'.$year.'/'.$month.'/';
     $posters_name = 'poster-case'.$year.$month.$day.'b'.$data['bar_id'].mb_substr(translit(preg_replace('/ /','',preg_replace('/[^\p{L}0-9 ]/iu','',($data['title'])))),0,5); // удаляем все стрёмные символы и пробелы
     if ($if_path == 1 && $if_name == 1) return $posters_path.$posters_name;
     else if ($if_path == 1) return $posters_path;
     else if ($if_name == 1) return $posters_name;
}

function upload_image() { // настройки загрузки постеров
     require_once('../class.upload/class.upload.php');
     $handle = new upload($_FILES['poster']);
     if ($handle->uploaded) {
          $handle->file_new_name_body = poster_path_template($_POST,0,1);
          $handle->file_max_size = 2048000; // максимально 2 мб загрузить можно
          $handle->file_overwrite = true;
          $handle->image_convert = 'jpg';
          $handle->jpeg_quality = 85;
          $handle->image_resize = true;
          $handle->image_ratio_y = true;
          $handle->image_x = 500;
          $handle->image_no_enlarging = true;
          $handle->process('../'.poster_path_template($_POST,1,0));
          if ($handle->processed) {
               $handle->clean();
          } else { echo 'error: '.$handle->error; }
     }
}

// отображение даты и времени
function new_time($d, $t) { // преобразовываем время в нормальный вид
     // date_default_timezone_set('Europe/Moscow'); перенёс вверх
     $ndate = date('j-m-Y', strtotime($d));
     $ndate_time = date('H:i', strtotime($t));
     $ndate_exp = explode('-', $ndate);
     $nmonth = array(
          1 => 'января',
          2 => 'февраля',
          3 => 'марта',
          4 => 'апреля',
          5 => 'мая',
          6 => 'июня',
          7 => 'июля',
          8 => 'августа',
          9 => 'сентября',
          10 => 'октября',
          11 => 'ноября',
          12 => 'декабря'
     );
     foreach ($nmonth as $key => $value) {
          if($key == intval($ndate_exp[1])) $nmonth_name = $value;
     }

     if($t == '') {
          if(date('Y', strtotime($d)) != date('Y')) return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' г.';
          else return $ndate_exp[0].' '.$nmonth_name; }

     elseif($ndate == date('d-m-Y')) return 'сегодня в '.$ndate_time;
     elseif($ndate == date('d-m-Y', strtotime('+1 day'))) return 'завтра в '.$ndate_time;
     // если год не текущий, то показать ещё и год
     elseif(date('Y', strtotime($d)) != date('Y')) return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' г. в '.$ndate_time;
     else return $ndate_exp[0].' '.$nmonth_name.' в '.$ndate_time;
}

// часы работы
function opening_hours($src, $day, $open_or_close) { // день недели 1-7; открыто - 0, закрыто 1
     $opening_days_array = explode(',', $src['opening_hours']);
     if (count($opening_days_array) != 7) return 'error opening-hours: non format in db (days count)';
     $day--;
     $time_txt = $opening_days_array[$day];

     if ($time_txt == '') {
          if ($day == 0) {
               return '';
          }
          else while ($time_txt == '') {
               $day--;
               $time_txt = $opening_days_array[$day];
               if ($day == 0 and $time_txt == '')
                    return '';
          }
     }
     if ($time_txt == 'x') {
          return '';
     }
     $time_array = explode('-', $time_txt);
     $time = $time_array[$open_or_close];
     if (strlen($time) == 4) {
          $opening_hours = substr($time, 0, 2).':'.substr($time, 2, 2);
     }
     else if (strlen($time) == 2) {
          $opening_hours = $time.':00';
     }
     else if ($time == 'x') {
          return '';
     }
     else {
          return 'error opening-hours: non format in db (time symbols count)';
     }
     return $opening_hours;
}

// массив часов работы → строка (для bar addit)
function opening_hours_string() {
     $hours_input = $_POST['opening_hours'];
     for ($i = 1; $i<8; $i++) {
          $hours_input[$i] = str_replace(':', '', $hours_input[$i]);
          if ($i>1 and $hours_input[$i] == $hours_input[$i-1]) {
               $opening_hours[$i-1] = '';
          }
          else if ($hours_input[$i][0] != '' and $hours_input[$i][1] != '') {
               for ($k = 0; $k<2; $k++) {
                    if (substr($hours_input[$i][$k], 2, 2) == '00') {
                    $hours_input_nozeros[$i][$k] = substr ($hours_input[$i][$k], 0, 2);
                    }
                    else $hours_input_nozeros[$i][$k] = $hours_input[$i][$k];
               }
               $opening_hours[$i-1] = $hours_input_nozeros[$i][0].'-'.$hours_input_nozeros[$i][1];
          }
          else $opening_hours[$i-1] = 'x';
     }
     if (implode(',',$opening_hours) == ',,,,,,') return '';
     return implode(',',$opening_hours);
}

// вывод типа кейса
function case_type($link, $case_id) {
     $query = sprintf("SELECT case_type FROM cases_types WHERE id=$case_id");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $case_type = mysqli_fetch_assoc($result);
     return $case_type['case_type'];
}

// вывод полного названия бара ссылкой
function bar_name($link, $bar_id) {
     $bar = bars_get($link, $bar_id);

     global $prefix;
     global $postfix;
     
     if ($bar['first_self'] == "1") {
          $prefix = $bar['type_self'].' '; }
     else $prefix='';
     if ($bar['first_self'] == "0") {
          $postfix = ' '.$bar['type_self']; }
     else $postfix='';

     $bar_name = $prefix.$bar['name'].$postfix;

     return '<a href="'.admin_url_home().'bar.php?id='.$bar_id.'" title="'.$bar_name.'">'.$bar_name.'</a>';
}

// вывод города для бэнда
function band_city($link, $city_id) {
     $query = sprintf("SELECT city FROM addr_cities WHERE id=$city_id");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $band_city = mysqli_fetch_row($result);
     return $band_city[0];
}

// вывод полного адреса бара
function bar_address($link, $bar_id, $with_city) {
     // улица
     $query = sprintf("SELECT street, city FROM addr_streets WHERE id=( SELECT addr_street FROM bars WHERE id=$bar_id )");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $street_name = mysqli_fetch_row($result);
     // город (по улице)
     $query = sprintf("SELECT city FROM addr_cities WHERE id=$street_name[1]");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $city_name = mysqli_fetch_row($result);
     // номер, корпус, литера
     $query = sprintf("SELECT addr_h, addr_h_k, addr_h_l FROM bars WHERE id=$bar_id");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $home_number = mysqli_fetch_row($result);
     
     if (!empty($home_number[1])) $home_korpus = ' корп. '.$home_number[1]; else $home_korpus = '';
     if (!empty($home_number[2])) $home_litera = ', лит. '.$home_number[2]; else $home_litera = '';
     
     if ($with_city == 1) {
          return ($city_name[0].', '.$street_name[0].', '.$home_number[0].$home_korpus.$home_litera); }
     else return ($street_name[0].', '.$home_number[0].$home_korpus.$home_litera);
}

// вывод этажа/ей бара
function bar_address_floor($link, $bar_id) {
     $query = sprintf("SELECT addr_floor FROM bars WHERE id=$bar_id");
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     $floor = mysqli_fetch_row($result);

     if (!isset($floor[0]) or $floor[0]=='') return ''; else {
          $floors = explode(',', $floor[0]);
          $n = count($floors);
          echo ' – ';
          if ($n == 1) {
               if ($floors[0] == '0') echo 'цокольный этаж';
               else echo $floors[0].'-й этаж';
          } else {
               if ($floors[0] == '0') {
                    echo 'цокольный';
                    array_shift($floors);
                    for ($i = 0; $i < $n-1; $i++) { echo ', '.$floors[$i]; }
               } else {
               echo $floors[0];
               for ($i = 1; $i < $n; $i++) { echo ', '.$floors[$i]; }
               }
               echo ' этажи';
               }
          }
     }

// стоимость входа для кейсов
function entry_price($price) {
     if (isset($price['entry_price'])) {
     if ($price['entry_price'] > 0) {echo 'Вход '.$price['entry_price'].' руб.<br>';}
     else {echo 'Вход свободный.<br>';} }
}

// показать, если не пусто, префикс, постфикс
function if_not_empty($prefix, $item, $postfix) {
     if (!empty($item)) echo $prefix.$item.$postfix;
}

// определяем ссылку
function recognize_url($prefix, $item, $postfix) {
     if (!empty ($item)) {
          return $prefix.preg_replace("/\b((http(s?):\/\/)|(www\.))([\w\.]+)([\/\w+\.]+)([\?\w+\.\=]+)([\&\w+\.\=]+)\b/i", "<a href=\"http$3://$4$5$6$7$8\" target=\"_blank\">$4$5$6$7$8</a>", $item).$postfix;
     }
}

// обрезание выводимого текста по словам
function text_trim($text,$len) {
     if (!empty ($text)) {
          $array = explode(" ",$text);
          $array = array_slice($array, 0, $len);
          echo implode(" ",$array).' ...';
     }
}

// сравнение и обновление линков при сабмите в addit
function addit_update_links($link, $table, $item, $for_who, $who_id, $input_array) {
     $query = sprintf("SELECT $item FROM $table WHERE $for_who=$who_id ORDER BY id ASC");
     $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
     
     $defined_items = [];
     for ($i = 0; $i < mysqli_num_rows($result); $i++) {
          $row = mysqli_fetch_row($result);
          $defined_items[] = $row[0];
     }
     $defined_items = array_diff($defined_items, array('')); // чистим от пустых значений
     if ($defined_items != []) {
          if (!isset($input_array) or ($input_array == '')) {
               $query = sprintf("DELETE FROM $table WHERE $for_who=$who_id");
               $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));    
          } else {
               $array_to_del = array_diff($defined_items, $input_array);
               if ($array_to_del != []) {
                    $ids_to_del = implode(',', $array_to_del);
                    $query = sprintf("DELETE FROM $table WHERE $for_who=$who_id AND $item IN($ids_to_del)");
                    $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
               }
               $array_to_add = array_diff($input_array, $defined_items);
               if ($array_to_add != []) {
                    foreach ($array_to_add as $value) {
                         $query = "INSERT INTO $table ($for_who, $item) VALUES ($who_id, $value)";
                         $result = mysqli_query($link, sprintf($query)); if (!$result) die(mysqli_error($link));
                    }
               }
          }
     } else if (isset($input_array) and ($input_array != '')) {
          foreach ($input_array as $value) {
               $query = "INSERT INTO $table ($for_who, $item) VALUES ($who_id, $value)";
               $result = mysqli_query($link, sprintf($query)); if (!$result) die(mysqli_error($link));
          }
     }
}


// вытаскивает связи - бд, таблица, что_вытащить, с_кем_связь
function link_ids($link, $prefix, $link_table, $what_to_show, $link_columns_to_show, $for_who, $id, $text_if_empty, $url_to_html, $temp, $postfix) {
     $query = sprintf("SELECT $what_to_show FROM $link_table WHERE $for_who='$id' AND $what_to_show IS NOT NULL ORDER BY $what_to_show DESC", (int)$id);
     $result = mysqli_query($link, $query);
     if (!$result)
        die(mysqli_error($link));
     // количество выбранных значений
     $n = mysqli_num_rows($result);
     if ($n == 0) { echo "$text_if_empty"; } else {
          $link_ids = array();
          // вытаскиываем нужные id-шники
          // require_once("models/..s.php");
          for ($i = 0; $i < $n; $i++) {
               $row = mysqli_fetch_assoc($result);
               $link_ids[] = $row;
               $link_id = $link_ids[$i][$what_to_show];
               // вытаскиваем из бд ассоциативный массив о текущем .. по id
               $sub_query = sprintf("SELECT * FROM $temp WHERE id='$link_id'", (int)$link_id);
               $sub_result = mysqli_query($link, $sub_query);
                    if (!$result) die(mysqli_error($link));
               $what = mysqli_fetch_assoc($sub_result); // $what = ..s_get($link, $link_id);
               // вытаскиваем значения из столбцов $link_columns_to_show
               for ($j = 0; $j < (count($link_columns_to_show)); $j++) {
                    ${'column'.($j+1)} = ' '.$what[$link_columns_to_show[$j]];
               }
               $column1 = trim($column1);
               if (!isset($column2)) {$column2 = '';}
               if (!isset($column3)) {$column3 = '';}
               $all_columns = trim(preg_replace('| +|',' ',$column1.$column2.$column3));
               // сохраняем ссылку html текущего ..
               $what_link = '<a href="'.admin_url_home().$url_to_html.'?id='.$link_id.'" title="'.$all_columns.'">'.$all_columns.'</a>';
               if ($i == 0) {echo $prefix;}
               if ($i > 0 and $i < ($n-1)) {echo ', ';}
               if ($i == ($n-1) and $n > 1) {echo ' и ';}
                    
               echo $what_link;
               if ($i == ($n-1) and $n > 0) {echo $postfix;}
          }
     }
}

// вытаскивает связи - для band.php (с перечислением инструментов)
function link_ids_for_bands($link, $prefix, $link_columns_to_show, $id, $text_if_empty, $postfix) {
     $query = sprintf("SELECT fella_id FROM link_fellas_bands WHERE band_id='$id' AND fella_id IS NOT NULL ORDER BY fella_id ASC");
     $result = mysqli_query($link, $query);
     if (!$result) die(mysqli_error($link));
     // количество выбранных значений
     $n = mysqli_num_rows($result);
     if ($n == 0) { echo "$text_if_empty"; } else {
          $link_ids = array();
          // вытаскиываем нужные id-шники
          for ($i = 0; $i < $n; $i++) {
               $row = mysqli_fetch_assoc($result);
               $link_ids[] = $row;
               $link_id = $link_ids[$i]['fella_id'];
               // вытаскиваем из бд ассоциативный массив о текущем .. по id
               $sub_query = sprintf("SELECT * FROM fellas WHERE id='$link_id'");
               $sub_result = mysqli_query($link, $sub_query);
                    if (!$sub_result) die(mysqli_error($link));
               $what = mysqli_fetch_assoc($sub_result);
               for ($j = 0; $j < (count($link_columns_to_show)); $j++) {
                    ${'column'.($j+1)} = ' '.$what[$link_columns_to_show[$j]];
               }
               $column1 = trim($column1);
               if (!isset($column2) or $column2==' ') $column2 = '';
               if (!isset($column3) or $column3==' ') $column3 = '';

               // запрос инструментов для текущего фэлла
               $my_instrs = array ('instrument');
               $sub_query_instr = sprintf("SELECT instrument_id FROM link_fellas_instruments WHERE fella_id='$link_id'");
               $sub_result_instr = mysqli_query($link, $sub_query_instr);
                    if (!$sub_result_instr) die(mysqli_error($link));
               $m = mysqli_num_rows($sub_result_instr);
               if ($m == 0) { $instr_text = ''; } else {
                    $link_ids_instr = array();
                    // вытаскиываем нужные id-шники
                    $instruments = array();
                    for ($k = 0; $k < $m; $k++) {
                         $row_instr = mysqli_fetch_assoc($sub_result_instr);
                         $link_ids_instr[] = $row_instr;
                         $link_id_instr = $link_ids_instr[$k]['instrument_id'];
                         // вытаскиваем из бд ассоциативный массив о текущем instr по id
                         $sub_query_instr_ids = sprintf("SELECT * FROM instruments WHERE id='$link_id_instr'");
                         $sub_result_instr_ids = mysqli_query($link, $sub_query_instr_ids);
                              if (!$sub_result_instr_ids) die(mysqli_error($link));
                         $what_instr = mysqli_fetch_assoc($sub_result_instr_ids);

                         if ($k == 0) $instr_a =' ('; else $instr_a = '';
                         if ($k > 0 and $k < ($m-1)) $instr_b = ', '; else $instr_b = '';
                         if ($k == ($m-1) and $m > 1) $instr_c = ' и '; else $instr_c = '';
                         if ($k == ($m-1) and $n > 0) $instr_d = ')'; else $instr_d = '';
                         
                         ${'instrument'.($k+1)} = $instr_a.$instr_b.$instr_c.$what_instr['instrument'].$instr_d;
                         $instruments[] = ${'instrument'.($k+1)};
                    }
                         $instr_text = '';
                         foreach ($instruments as $key => $value) { 
                              $instr_text .= $value;
                         }
               }

               // сохраняем ссылку html текущего фэлла
               $what_link = '<a href="'.'fella.php'.'?id='.$link_id.'" title="'.$column1.$column2.$column3.'">'.$column1.$column2.$column3.'</a>'.$instr_text;
               if ($i == 0) {echo $prefix;}
               if ($i > 0 and $i < ($n-1)) {echo ', ';}
               if ($i == ($n-1) and $n > 1) {echo ' и ';}
                    
               echo $what_link;
               if ($i == ($n-1) and $n > 0) {echo $postfix;}
          }
     }
}

?>