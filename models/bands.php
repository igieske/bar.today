<?php

function bands_all($link) {
     $query = "SELECT * FROM bands ORDER BY id DESC";
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $n = mysqli_num_rows($result);
     $bands = array();

     for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $bands[] = $row;
     }
     return $bands;
}

function bands_get($link, $id_band) {
     $query = sprintf("SELECT * FROM bands WHERE id=%d", (int)$id_band);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $band = mysqli_fetch_assoc($result);
     return $band;
}

function bands_new($link, 
     $name,
     $city_id,
     $motto,
     $description_brief,
     $description,
     $phone,
     $phone_info,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $twitter_link,
     $input_musicstyles,
     $input_fellas) {
     
     $name = str_replace('"','',$name); // стераем двойные кавычки, чтобы норм работал скрипт в case-addit.php

     $name = trim($name);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $phone_info = trim($phone_info);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $twitter_link = trim($twitter_link);

     if ($name == '') return false;

     $t = "INSERT INTO bands (

          name,
          city_id,
          motto,
          description_brief,
          description,
          phone,
          phone_info,
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
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $city_id),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone_info),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $twitter_link));

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $band_id = mysqli_insert_id($link);
     // создаём связи в link_bands_musicstyles
     if ($input_musicstyles != '') {
          for ($i = 0; $i < count($input_musicstyles); $i++) {
               $input_musicstyle = $input_musicstyles[$i];
               $u = "INSERT INTO link_bands_musicstyles (band_id, musicstyle_id) VALUES (
                    $band_id, $input_musicstyle)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }
     // создаём связи в link_fellas_bands
     if ($input_fellas != '') {
          for ($i = 0; $i < count($input_fellas); $i++) {
               $input_fella = $input_fellas[$i];
               $u = "INSERT INTO link_fellas_bands (fella_id, band_id) VALUES (
                    $input_fella, $band_id)";
               $result = mysqli_query($link, sprintf($u));
                    if (!$result) die(mysqli_error($link));
          }
     }

     return true;
}

function bands_edit($link, $id, 
     $name,
     $city_id,
     $motto,
     $description_brief,
     $description,
     $phone,
     $phone_info,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $twitter_link,
     $input_musicstyles,
     $input_fellas) {
     
     $name = str_replace('"','',$name); // стераем двойные кавычки, чтобы норм работал скрипт в case-addit.php

     $name = trim($name);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $phone_info = trim($phone_info);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $twitter_link = trim($twitter_link);

     $id = (int)$id;

     if ($name == '') return false;

     $sql = "UPDATE bands SET 
          name='%s',
          city_id='%s',
          motto='%s',
          description_brief='%s',
          description='%s',
          phone='%s',
          phone_info='%s',
          email='%s',
          site='%s',
          vk_link='%s',
          instagram_link='%s',
          fb_link='%s',  
          twitter_link='%s'

          WHERE id='%d'";
     
     $query = sprintf($sql,
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $city_id),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone_info),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $twitter_link),
          $id);

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     // обновляем связи в link_bands_musicstyles
     addit_update_links($link, 'link_bands_musicstyles', 'musicstyle_id', 'band_id', $id, $input_musicstyles);

     // обновляем связи в link_fellas_bands
     addit_update_links($link, 'link_fellas_bands', 'fella_id', 'band_id', $id, $input_fellas);

     return mysqli_affected_rows($link);
}

function bands_del($link, $id) {
     $id = (int)$id;
     if ($id == 0) return false;

     $query = sprintf("DELETE FROM bands WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return mysqli_affected_rows($link);    
}

?>