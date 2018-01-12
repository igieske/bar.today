<?php

function bars_all($link) {
     $query = "SELECT * FROM bars ORDER BY id DESC";
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $n = mysqli_num_rows($result);
     $bars = array();

     for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $bars[] = $row;
     }
     return $bars;
}

function bars_get($link, $id_bar) {
     $query = sprintf("SELECT * FROM bars WHERE id=%d", (int)$id_bar);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));

     $bar = mysqli_fetch_assoc($result);
     return $bar;
}

function bars_new($link,
     $name,
     $name2,
     $name3,
     $type_self,
     $first_self,
     $addr_street,
     $addr_h,
     $addr_h_k,
     $addr_h_l,
     $addr_floor,
     $opening_hours,
     $opening_hours_comment,
     $phone,
     $phone_info,
     $phone2,
     $phone2_info,
     $phone3,
     $phone3_info,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $motto,
     $description_brief,
     $description,
     $price_draftbeer_min,
     $price_draftbeer_max) {

     $name = trim($name);
     $name2 = trim($name2);
     $name3 = trim($name3);
     $type_self = trim($type_self);
     $first_self = trim($first_self);
     $addr_street = trim($addr_street);
     $addr_h = trim($addr_h);
     $addr_h_k = trim($addr_h_k);
     $addr_h_l = trim($addr_h_l);
     $addr_floor = trim($addr_floor);
     $opening_hours_comment = trim($opening_hours_comment);
     $phone = trim($phone);
     $phone_info = trim($phone_info);
     $phone2 = trim($phone2);
     $phone2_info = trim($phone2_info);
     $phone3 = trim($phone3);
     $phone3_info = trim($phone3_info);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $price_draftbeer_min = trim($price_draftbeer_min);
     $price_draftbeer_max = trim($price_draftbeer_max);
     
     if ($name == '') return false;
     if ($addr_floor == '') $addr_floor = 'NULL';
          else $addr_floor = '"'.mysqli_real_escape_string($link, $addr_floor).'"';
     
     $t = "INSERT INTO bars (

          name,
          name2,
          name3,
          type_self,
          first_self,
          addr_street,
          addr_h,
          addr_h_k,
          addr_h_l,
          addr_floor,
          opening_hours,
          opening_hours_comment,
          phone,
          phone_info,
          phone2,
          phone2_info,
          phone3,
          phone3_info,
          email,
          site,
          vk_link,
          instagram_link,
          fb_link,
          motto,
          description_brief,
          description,
          price_draftbeer_min,
          price_draftbeer_max ) VALUES (

          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          $addr_floor,
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
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s')";

     $query = sprintf($t,
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $name2),
          mysqli_real_escape_string($link, $name3),
          mysqli_real_escape_string($link, $type_self),
          mysqli_real_escape_string($link, $first_self),
          mysqli_real_escape_string($link, $addr_street),
          mysqli_real_escape_string($link, $addr_h),
          mysqli_real_escape_string($link, $addr_h_k),
          mysqli_real_escape_string($link, $addr_h_l),
          mysqli_real_escape_string($link, $opening_hours),
          mysqli_real_escape_string($link, $opening_hours_comment),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone_info),
          mysqli_real_escape_string($link, $phone2),
          mysqli_real_escape_string($link, $phone2_info),
          mysqli_real_escape_string($link, $phone3),
          mysqli_real_escape_string($link, $phone3_info),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $price_draftbeer_min),
          mysqli_real_escape_string($link, $price_draftbeer_max));

     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return true;
}

function bars_edit($link, $id, 
     $name,
     $name2,
     $name3,
     $type_self,
     $first_self,
     $addr_street,
     $addr_h,
     $addr_h_k,
     $addr_h_l,
     $addr_floor,
     $opening_hours,
     $opening_hours_comment,
     $phone,
     $phone_info,
     $phone2,
     $phone2_info,
     $phone3,
     $phone3_info,
     $email,
     $site,
     $vk_link,
     $instagram_link,
     $fb_link,
     $motto,
     $description_brief,
     $description,
     $price_draftbeer_min,
     $price_draftbeer_max) {

     $name = trim($name);
     $name2 = trim($name2);
     $name3 = trim($name3);
     $type_self = trim($type_self);
     $first_self = trim($first_self);
     $addr_street = trim($addr_street);
     $addr_h = trim($addr_h);
     $addr_h_k = trim($addr_h_k);
     $addr_h_l = trim($addr_h_l);
     $addr_floor = trim($addr_floor);
     $opening_hours_comment = trim($opening_hours_comment);
     $phone = trim($phone);
     $phone_info = trim($phone_info);
     $phone2 = trim($phone2);
     $phone2_info = trim($phone2_info);
     $phone3 = trim($phone3);
     $phone3_info = trim($phone3_info);
     $email = trim($email);
     $site = trim($site);
     $vk_link = trim($vk_link);
     $instagram_link = trim($instagram_link);
     $fb_link = trim($fb_link);
     $motto = trim($motto);
     $description_brief = trim($description_brief);
     $description = trim($description);
     $price_draftbeer_min = trim($price_draftbeer_min);
     $price_draftbeer_max = trim($price_draftbeer_max);

     $id = (int)$id;

     if ($name == '') return false;
     if ($addr_floor == '') $addr_floor = 'NULL';
          else $addr_floor = '"'.mysqli_real_escape_string($link, $addr_floor).'"';

     $sql = "UPDATE bars SET
          name='%s',
          name2='%s',
          name3='%s',
          type_self='%s',
          first_self='%s',
          addr_street='%s',
          addr_h='%s',
          addr_h_k='%s',
          addr_h_l='%s',
          addr_floor=$addr_floor,
          opening_hours='%s',
          opening_hours_comment='%s',
          phone='%s',
          phone_info='%s',
          phone2='%s',
          phone2_info='%s',
          phone3='%s',
          phone3_info='%s',
          email='%s',
          site='%s',
          vk_link='%s',
          instagram_link='%s',
          fb_link='%s',
          motto='%s',
          description_brief='%s',
          description='%s',
          price_draftbeer_min='%s',
          price_draftbeer_max='%s'

          WHERE id='%d'";

     $query = sprintf($sql,
          mysqli_real_escape_string($link, $name),
          mysqli_real_escape_string($link, $name2),
          mysqli_real_escape_string($link, $name3),
          mysqli_real_escape_string($link, $type_self),
          mysqli_real_escape_string($link, $first_self),
          mysqli_real_escape_string($link, $addr_street),
          mysqli_real_escape_string($link, $addr_h),
          mysqli_real_escape_string($link, $addr_h_k),
          mysqli_real_escape_string($link, $addr_h_l),
          mysqli_real_escape_string($link, $opening_hours),
          mysqli_real_escape_string($link, $opening_hours_comment),
          mysqli_real_escape_string($link, $phone),
          mysqli_real_escape_string($link, $phone_info),
          mysqli_real_escape_string($link, $phone2),
          mysqli_real_escape_string($link, $phone2_info),
          mysqli_real_escape_string($link, $phone3),
          mysqli_real_escape_string($link, $phone3_info),
          mysqli_real_escape_string($link, $email),
          mysqli_real_escape_string($link, $site),
          mysqli_real_escape_string($link, $vk_link),
          mysqli_real_escape_string($link, $instagram_link),
          mysqli_real_escape_string($link, $fb_link),
          mysqli_real_escape_string($link, $motto),
          mysqli_real_escape_string($link, $description_brief),
          mysqli_real_escape_string($link, $description),
          mysqli_real_escape_string($link, $price_draftbeer_min),
          mysqli_real_escape_string($link, $price_draftbeer_max),
          $id);
     
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return mysqli_affected_rows($link);
}

function bars_del($link, $id) {
     $id = (int)$id;
     if ($id == 0) return false;

     $query = sprintf("DELETE FROM bars WHERE id='%d'", $id);
     $result = mysqli_query($link, $query);
          if (!$result) die(mysqli_error($link));
     return mysqli_affected_rows($link);    
}

?>