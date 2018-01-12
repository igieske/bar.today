<?php
     ob_start(); // иначе при редиректе header("Location: ...") ошибка - повторная отправка заголовков. либо юзать <script>location.href="index.php";</script>;
     function idkfa(){};
     require_once("../database.php");

     require_once("../models/bars.php");
     require_once("../models/cases.php");
     require_once("../models/bands.php");
     require_once("../models/fellas.php");
     require_once("../models/instruments.php");
     require_once("../models/musicstyles.php");

     require_once("../models/functions.php");

     $link = db_connect();

     if(isset($_GET['action']))
          $action = $_GET['action'];
     else $action = '';

     include("../views/header.php");

// bars

     if($action == "add-bar"){
          if(!empty($_POST)){
               bars_new($link,
                    $_POST['name'],
                    $_POST['name2'],
                    $_POST['name3'],
                    $_POST['type_self'],
                    $_POST['first_self'],
                    $_POST['addr_street'],
                    $_POST['addr_h'],
                    $_POST['addr_h_k'],
                    $_POST['addr_h_l'],
                    implode(',',$_POST['floor']), // собираем массив с этажами → в строку
                    opening_hours_string(), // в functions: массив с часами → в строку
                    $_POST['opening_hours_comment'],
                    $_POST['phone'],
                    $_POST['phone_info'],
                    $_POST['phone2'],
                    $_POST['phone2_info'],
                    $_POST['phone3'],
                    $_POST['phone3_info'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['price_draftbeer_min'],
                    $_POST['price_draftbeer_max']);
               header("Location: index.php");
          }
          include("../views/bar-addit.php");
     }
     else if($action == "edit-bar"){
          if(!isset($_GET['id']))
               header("Location: index.php");
          $id = (int)$_GET['id'];
     
          if(!empty($_POST) && $id > 0){
               bars_edit($link, $id,
                    $_POST['name'],
                    $_POST['name2'],
                    $_POST['name3'],
                    $_POST['type_self'],
                    $_POST['first_self'],
                    $_POST['addr_street'],
                    $_POST['addr_h'],
                    $_POST['addr_h_k'],
                    $_POST['addr_h_l'],
                    implode(',',$_POST['floor']), // собираем массив с этажами → в строку
                    opening_hours_string(),
                    $_POST['opening_hours_comment'],
                    $_POST['phone'],
                    $_POST['phone_info'],
                    $_POST['phone2'],
                    $_POST['phone2_info'],
                    $_POST['phone3'],
                    $_POST['phone3_info'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['price_draftbeer_min'],
                    $_POST['price_draftbeer_max']);
               header("Location: ../bar.php?id=$id");
          }
          $bar = bars_get($link, $id);
          include("../views/bar-addit.php");
     }
     else if($action == "del-bar"){
          $id = $_GET['id'];
          $bar = bars_del($link, $id);
          header("Location: index.php"); 
     }

// cases

     else if($action == "add-case"){
          if(!empty($_POST)){
               cases_new($link,
                    $_POST['case_type'],
                    $_POST['title'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['date'],
                    $_POST['one_day_or'],
                    $_POST['start_time'],
                    $_POST['entry_price'],
                    $_POST['bar_id'],
                    $_POST['input_fellas'],
                    $_POST['input_bands']);
               // загрузка постера
               if ($_FILES['poster']['size'] > 0){ // если число переданных файлов > 0
                    upload_image();
               }
               header("Location: index.php");
          }
          include("../views/case-addit.php");
     }
     else if($action == "edit-case"){
          if(!isset($_GET['id']))
               header("Location: index.php");
          $id = (int)$_GET['id'];
     
          if(!empty($_POST) && $id > 0){
               cases_edit($link, $id,
                    $_POST['case_type'],
                    $_POST['title'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['date'],
                    $_POST['one_day_or'],
                    $_POST['start_time'],
                    $_POST['entry_price'],
                    $_POST['bar_id'],
                    $_POST['input_fellas'],
                    $_POST['input_bands']);
               // изменение постера
               if ($_FILES['poster']['size'] > 0){ // если число переданных файлов > 0
                    upload_image();
               }
               header("Location: ../case.php?id=$id");
          }
          $case = cases_get($link, $id);
          include("../views/case-addit.php");
     }
     else if($action == "del-case"){
          $id = $_GET['id'];
          $id = (int)$id;
          if ($id == 0)
               return false;
          // удаляем постер
          $query = sprintf("SELECT title, date, bar_id FROM cases WHERE id='%d'", $id);
          $result = mysqli_query($link, $query);
               if (!$result) die(mysql_error($link));
          $cases_to_delete = mysqli_fetch_array($result);

          if (file_exists(admin_url_home().poster_path_template($cases_to_delete,1,1).'.jpg'))
               unlink(admin_url_home().poster_path_template($cases_to_delete,1,1).'.jpg');

          $case = cases_del($link, $id);
          header("Location: index.php");
     }

// bands

     else if($action == "add-band"){
          if(!empty($_POST)){
               if (!isset($_POST['input_musicstyles'])) $_POST['input_musicstyles'] = '';
               if (!isset($_POST['input_fellas'])) $_POST['input_fellas'] = '';
               bands_new($link,
                    $_POST['name'],
                    $_POST['city_id'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['phone'],
                    $_POST['phone_info'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['twitter_link'],
                    $_POST['input_musicstyles'],
                    $_POST['input_fellas']);
               header("Location: index.php");
          }
          include("../views/band-addit.php");
     }
     else if($action == "edit-band"){
          if(!isset($_GET['id']))
               header("Location: index.php");
          $id = (int)$_GET['id'];
          if(!empty($_POST) && $id > 0){
               if (!isset($_POST['input_musicstyles'])) $_POST['input_musicstyles'] = '';
               if (!isset($_POST['input_fellas'])) $_POST['input_fellas'] = '';
               bands_edit($link, $id,
                    $_POST['name'],
                    $_POST['city_id'],
                    $_POST['motto'],
                    $_POST['description_brief'],
                    $_POST['description'],
                    $_POST['phone'],
                    $_POST['phone_info'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['twitter_link'],
                    $_POST['input_musicstyles'],
                    $_POST['input_fellas']);
               header("Location: ../band.php?id=$id");
          }
          $band = bands_get($link, $id);
          include("../views/band-addit.php");
     }
     else if($action == "del-band"){
          $id = $_GET['id'];
          $band = bands_del($link, $id);
          header("Location: index.php");
     }

// fellas

     else if($action == "add-fella"){
          if(!empty($_POST)){
               if (!isset($_POST['input_bands'])) $_POST['input_bands'] = '';
               if (!isset($_POST['input_instruments'])) $_POST['input_instruments'] = '';
               fellas_new($link,
                    $_POST['last_name'],
                    $_POST['name'],
                    $_POST['pseudonym'],
                    $_POST['gender'],
                    $_POST['dob'],
                    $_POST['about'],
                    $_POST['phone'],
                    $_POST['phone2'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['twitter_link'],
                    $_POST['input_bands'],
                    $_POST['input_instruments']);
               header("Location: index.php");
          }
          include("../views/fella-addit.php");
     }
     else if($action == "edit-fella"){
          if(!isset($_GET['id']))
               header("Location: index.php");
          $id = (int)$_GET['id'];
     
          if(!empty($_POST) && $id > 0){
               if (!isset($_POST['input_bands'])) $_POST['input_bands'] = '';
               if (!isset($_POST['input_instruments'])) $_POST['input_instruments'] = '';
               fellas_edit($link, $id,
                    $_POST['last_name'],
                    $_POST['name'],
                    $_POST['pseudonym'],
                    $_POST['gender'],
                    $_POST['dob'],
                    $_POST['about'],
                    $_POST['phone'],
                    $_POST['phone2'],
                    $_POST['email'],
                    $_POST['site'],
                    $_POST['vk_link'],
                    $_POST['instagram_link'],
                    $_POST['fb_link'],
                    $_POST['twitter_link'],
                    $_POST['input_bands'],
                    $_POST['input_instruments']);
               header("Location: ../fella.php?id=$id");
          }
          $fella = fellas_get($link, $id);
          include("../views/fella-addit.php");
     }
     else if($action == "del-fella"){
          $id = $_GET['id'];
          $fella = fellas_del($link, $id);
          header("Location: index.php");
     }

// else

     else{
          $bars = bars_all($link);
          $cases = cases_all($link);
          $bands = bands_all($link);
          $fellas = fellas_all($link);
     ?>
     <div id="main-view">
          <div><?php include("../views/bars.php"); ?></div>
          <div><?php include("../views/cases.php"); ?></div>
          <div><?php include("../views/bands.php"); ?></div>
          <div><?php include("../views/fellas.php"); ?></div>
     </div>
     <?php } ?>
<?php include("../views/footer.php"); ?>