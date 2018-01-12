<?php

function fellas_all($link) {
     $query = "SELECT * FROM fellas ORDER BY id DESC";
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $n = mysqli_num_rows($result);
     $fellas = array();

     for ($i = 0; $i < $n; $i++) {
          $row = mysqli_fetch_assoc($result);
          $fellas[] = $row;
     }
     return $fellas;
}

function fellas_get($link, $id_fella) {
     $query = sprintf("SELECT * FROM fellas WHERE id=%d", (int)$id_fella);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $fella = mysqli_fetch_assoc($result);
     return $fella;
}

function fellas_new($link,
     $last_name,
     $name,
     $pseudonym,
     $gender,
     $dob,
     $about,
     $phone,
     $phone2,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $twitter_link,
     $input_bands,
     $input_instruments) {

     $last_name = trim($last_name);
     $name = trim($name);
     $pseudonym = trim($pseudonym);
     $about = trim($about);
     $phone = trim($phone);
     $phone2 = trim($phone2);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $twitter_link = trim($twitter_link);
     
     //if ($name == '') return false;
     if ($dob == '') $dob = 'NULL';
          else $dob = '"'.mysqli_real_escape_string($link, $dob).'"';
     
     $t = "INSERT INTO fellas (

          last_name,
          name,
          pseudonym,
          gender,
          dob,
          about,
          phone,
          phone2,
          email,
          site,
          vk_link,
          instagram_link,
          fb_link,
          twitter_link ) VALUES (

          '%s',
          '%s',
          '%s',
          '%s',
          $dob,
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s')";
     
     $query = sprintf($t,
          mysqli_real_escape_string($link, $last_name),
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $pseudonym),
          mysqli_real_escape_string($link, $gender),
          mysqli_real_escape_string($link, $about),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone2),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $twitter_link));

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $fella_id = mysqli_insert_id($link);

     // создаём связи в link_fellas_bands

     if ($input_bands != '') {
          for ($i = 0; $i < count($input_bands); $i++) {
               $input_band = $input_bands[$i];
               $u = "INSERT INTO link_fellas_bands (fella_id, band_id) VALUES (
                    $fella_id, $input_band)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }

     // создаём связи в link_fellas_instruments

     if ($input_instruments != '') {
          for ($i = 0; $i < count($input_instruments); $i++) {
               $input_instrument = $input_instruments[$i];
               $u = "INSERT INTO link_fellas_instruments (fella_id, instrument_id) VALUES (
                    $fella_id, $input_instrument)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }

     return true;
}

function fellas_edit($link, $id, 
     $last_name,
     $name,
     $pseudonym,
     $gender,
     $dob,
     $about,
     $phone,
     $phone2,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $twitter_link,
     $input_bands,
     $input_instruments) {

     $last_name = trim($last_name);
     $name = trim($name);
     $pseudonym = trim($pseudonym);
     $about = trim($about);
     $phone = trim($phone);
     $phone2 = trim($phone2);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $twitter_link = trim($twitter_link);

     $id = (int)$id;

     if ($name == '') return false;
     if ($dob == '') $dob = 'NULL';
          else $dob = '"'.mysqli_real_escape_string($link, $dob).'"';

     $sql = "UPDATE fellas SET

          last_name='%s',
          name='%s',
          pseudonym='%s',
          gender='%s',
          dob=$dob,
          about='%s',
          phone='%s',
          phone2='%s',
          email='%s',
          site='%s',
          vk_link='%s',
          instagram_link='%s',
          fb_link='%s',  
          twitter_link='%s'

          WHERE id='%d'";

     $query = sprintf($sql,
          mysqli_real_escape_string($link, $last_name),
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $pseudonym),
          mysqli_real_escape_string($link, $gender),
          mysqli_real_escape_string($link, $about),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone2),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $twitter_link),
          $id);

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     // обновляем связи в link_fellas_bands
     addit_update_links($link, 'link_fellas_bands', 'band_id', 'fella_id', $id, $input_bands);

     // обновляем связи в link_fellas_instruments
     addit_update_links($link, 'link_fellas_instruments', 'instrument_id', 'fella_id', $id, $input_instruments);

     return mysqli_affected_rows($link);
}

function fellas_del($link, $id) {
     $id = (int)$id;
     if ($id == 0) return false;
     
     $query = sprintf("DELETE FROM fellas WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return mysqli_affected_rows($link);    
}

?>