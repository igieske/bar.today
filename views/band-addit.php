<?php // достаём списки стилей
     function musicstyles_list($link) {
          $query = sprintf("SELECT id, musicstyle FROM musicstyles ORDER BY musicstyle ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.$object['musicstyle'].'</option>';
          endwhile;
     }
?>
<?php // достаём списки фэллас
     function fellas_list($link) {
          $query = sprintf("SELECT id, name, pseudonym, last_name FROM fellas ORDER BY name ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.fio($object).'</option>';
          endwhile;
     }
?>
<script type="text/javascript">
     var total_musicstyles = 0;
     // кнопка "добавить стиль"
     var musicstyles_list = "<?=musicstyles_list($link)?>";
     function add_new_musicstyle(){
          total_musicstyles++;
          $('<tr>')
          .attr('id','tr_musicstyle_'+total_musicstyles)
          .append (
               $('<td>')
               .append(
                    $('<select>')
                    .css({width:'-webkit-fill-available'})
                    .attr('name',"input_musicstyles[]")
                    .attr('required','')
                    .append (
                         $('<option>')
                         .attr('disabled','')
                         .attr('selected','')
                    )
                    .append (
                         $(musicstyles_list)
                    )
               )
          )
          .append(
               $('<td>')
               .append(
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_musicstyle_'+total_musicstyles+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_musicstyles');                
     }
</script>
<script type="text/javascript">
     var total_fellas = 0;
     // кнопка "добавить фэлла"
     var fellas_list = "<?=fellas_list($link)?>";
     function add_new_fella(){
          total_fellas++;
          $('<tr>')
          .attr('id','tr_fella_'+total_fellas)
          .append (
               $('<td>')
               .append(
                    $('<select>')
                    .css({width:'-webkit-fill-available'})
                    .attr('name',"input_fellas[]")
                    .attr('required','')
                    .append (
                         $('<option>')
                         .attr('disabled','')
                         .attr('selected','')
                    )
                    .append (
                         $(fellas_list)
                    )
               )
          )
          .append(
               $('<td>')
               .append(
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_fella_'+total_fellas+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_fellas');                
     }
</script>
<div>     
     <form method="post" action="index.php?action=<?=$_GET['action']?><?php if (isset($_GET['id'])) echo '&id='.$_GET['id'];?>">
          <label>
               Название бэнда *
               <input type="text" name="name" value="<?php if (isset($_GET['id'])) echo $band['name']; ?>" autofocus required>
               <!-- в названии бэнда не допускаются двойные ковычки для норм работы скриптов - кавычки стираются при передаче запроса -->
          </label>
          <br>
          Город *
          <select name="city_id" required>
               <option selected value="<?php if (isset($_GET['id'])) echo $band['city_id']; ?>"><?php if (isset($_GET['id'])) echo band_city($link, $band['city_id'])?></option>
          <?php $query = sprintf("SELECT id, city FROM addr_cities ORDER BY id ASC");
               $result = mysqli_query($link, $query);
                    if (!$result) die(mysqli_error($link));
               while($object = mysqli_fetch_assoc($result)):?>
               <option value="<?=$object['id']?>"><?=$object['city']?></option>
          <?php endwhile;?>
          </select>
          <br>
          <label>
               Мотто
               <input type="text" name="motto" value="<?php if (isset($_GET['id'])) echo $band['motto']; ?>"> 
          </label>
          <br>
          <label>
               Краткое описание
               <textarea name="description_brief"><?php if (isset($_GET['id'])) echo $band['description_brief']; ?></textarea>
          </label>
          <br>
          <label>
               Описание
               <textarea name="description"><?php if (isset($_GET['id'])) echo $band['description']; ?></textarea>
          </label>
          <br>
          <div class="bordered">
               <b>Муз. стили:</b>
                    <input type="button" id="add" onclick="return add_new_musicstyle();" value="Добавить муз. стиль">
                    <table id="table_musicstyles">
                    <?php if (isset($_GET['id'])) {
                         $band_id = $_GET['id'];
                         $query = sprintf("SELECT musicstyle_id FROM link_bands_musicstyles WHERE band_id=$band_id");
                              $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
                         $n = mysqli_num_rows($result);
                         if ($n != 0) {
                              $musicstyle_inputs = array();
                              for ($i = 0; $i < $n; $i++) {
                                 $row = mysqli_fetch_assoc($result);
                                 $musicstyle_inputs[] = $row;
                              }
                              for ($k = 0; $k < $n; $k++) {
                                   if (!isset($a)) $a = 1; else $a++;
                                   $input_item_n = $a.'_defined';
                                   $delete_action = "$('#tr_musicstyle_".$input_item_n."').remove();";
                                   $c = musicstyles_get($link, $musicstyle_inputs[$k]['musicstyle_id']);
                                   $who = $c['musicstyle'];
                                   echo '<tr id="tr_musicstyle_'.$input_item_n.'">
                                   <td><select name="input_musicstyles[]" required="required" style="width: -webkit-fill-available;">
                                        <option selected value="'.$musicstyle_inputs[$k]['musicstyle_id'].'">'.$who.'</option></select></td>
                                   <td><a style="cursor:pointer;" onclick="'.$delete_action.'">Удалить</a></td></tr>';
                              }
                              unset($a);
                         }
                    } ?>
                    </table>
          </div>
          <div class="bordered">
               <b>Фэллас:</b>
                    <input type="button" id="add" onclick="return add_new_fella();" value="Добавить фелла">
                    <table id="table_fellas">
                    <?php if (isset($_GET['id'])) {
                         $band_id = $_GET['id'];
                         $query = sprintf("SELECT fella_id FROM link_fellas_bands WHERE band_id=$band_id");
                              $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
                         $n = mysqli_num_rows($result);
                         if ($n != 0) {
                              $fella_inputs = array();
                              for ($i = 0; $i < $n; $i++) {
                                 $row = mysqli_fetch_assoc($result);
                                 $fella_inputs[] = $row;
                              }
                              for ($k = 0; $k < $n; $k++) {
                                   if (!isset($a)) $a = 1; else $a++;
                                   $input_item_n = $a.'_defined';
                                   $delete_action = "$('#tr_fella_".$input_item_n."').remove();";
                                   $c = fellas_get($link, $fella_inputs[$k]['fella_id']);
                                   $who = fio($c);
                                   echo '<tr id="tr_fella_'.$input_item_n.'">
                                   <td><select name="input_fellas[]" required="required" style="width: -webkit-fill-available;">
                                        <option selected value="'.$fella_inputs[$k]['fella_id'].'">'.$who.'</option></select></td>
                                   <td><a style="cursor:pointer;" onclick="'.$delete_action.'">Удалить</a></td></tr>';
                              }
                              unset($a);
                         }
                    } ?>
                    </table>
          </div>
          <h4>Контакты</h4>
          <label>
               Телефон
               <input type="text" name="phone" value="<?php if (isset($_GET['id'])) echo $band['phone']; ?>" pattern="^[0-9]+$"> 
          </label>
               <label>
                    <input type="text" name="phone_info" value="<?php if (isset($_GET['id'])) echo $band['phone_info']; ?>" placeholder="комментарий"> 
               </label>
          <br>
          <label>
               Электропочта
               <input type="email" name="email" value="<?php if (isset($_GET['id'])) echo $band['email']; ?>">
          </label>
          <br>
          <label>
               Сайт
               <input type="url" name="site" value="<?php if (isset($_GET['id'])) echo $band['site']; ?>">
          </label>
          <br>
          <label>
               Vk
               <input type="url" name="vk_link" value="<?php if (isset($_GET['id'])) echo $band['vk_link']; ?>">
          </label>
          <br>
          <label>
               Instagram
               <input type="url" name="instagram_link" value="<?php if (isset($_GET['id'])) echo $band['instagram_link']; ?>">
          </label>
          <br>
          <label>
               Facebook
               <input type="url" name="fb_link" value="<?php if (isset($_GET['id'])) echo $band['fb_link']; ?>">
          </label>
          <br>
          <label>
               Twitter
               <input type="url" name="twitter_link" value="<?php if (isset($_GET['id'])) echo $band['twitter_link']; ?>">
          </label>
          <br>
          <input type="submit" value="Сохранить">
     </form>
</div>