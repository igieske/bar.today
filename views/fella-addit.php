<?php // достаём списки бэндов
     function bands_list($link) {
          $query = sprintf("SELECT id, name FROM bands ORDER BY name ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.$object['name'].'</option>';
          endwhile;
     }
?>
<?php // достаём списки инструментов
     function instruments_list($link) {
          $query = sprintf("SELECT id, instrument FROM instruments ORDER BY instrument ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.$object['instrument'].'</option>';
          endwhile;
     }
?>
<script type="text/javascript">
     // если псевдоним введён, то имя и фамилия необязательны
     function pseudonym_have(){
          if ($('#pseudonym').val() != '') {
               $('#name').removeAttr('required');
               $('#last_name').removeAttr('required');
          }
          else {
               $('#name').attr('required','');
               $('#last_name').attr('required','');
          }
     }
</script>
<script type="text/javascript">
     var total_bands = 0;
     // кнопка "добавить бэнд"
     var bands_list = "<?=bands_list($link)?>";
     function add_new_band(){
          total_bands++;
          $('<tr>')
          .attr('id','tr_band_'+total_bands)
          .append (
               $('<td>')
               .append(
                    $('<select>')
                    .css({width:'-webkit-fill-available'})
                    .attr('name',"input_bands[]")
                    .attr('required','')
                    .append (
                         $('<option>')
                         .attr('disabled','')
                         .attr('selected','')
                    )
                    .append (
                         $(bands_list)
                    )
               )
          )
          .append(
               $('<td>')
               .append(
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_band_'+total_bands+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_bands');                
     }
</script>
<script type="text/javascript">
     var total_instruments = 0;
     // кнопка "добавить инструмент"
     var instruments_list = "<?=instruments_list($link)?>";
     function add_new_instrument(){
          total_instruments++;
          $('<tr>')
          .attr('id','tr_instrument_'+total_instruments)
          .append (
               $('<td>')
               .append(
                    $('<select>')
                    .css({width:'-webkit-fill-available'})
                    .attr('name',"input_instruments[]")
                    .attr('required','')
                    .append (
                         $('<option>')
                         .attr('disabled','')
                         .attr('selected','')
                    )
                    .append (
                         $(instruments_list)
                    )
               )
          )
          .append(
               $('<td>')
               .append(
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_instrument_'+total_instruments+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_instruments');                
     }
</script>
    
<div>
     <form method="post" action="index.php?action=<?=$_GET['action']?><?php if (isset($_GET['id'])) echo '&id='.$_GET['id'];?>">
          <div class="bordered">
               <label>
                    Имя
                    <input type="text" name="name" value="<?php if (isset($_GET['id'])) echo $fella['name']; ?>" id="name" autofocus required>
               </label>
               <br>
               <label>
                    Фамилия
                    <input type="text" name="last_name" value="<?php if (isset($_GET['id'])) echo $fella['last_name']; ?>" id="last_name" required>
               </label>
               <br>
               <label>
                    Псевдоним
                    <input type="text" name="pseudonym" value="<?php if (isset($_GET['id'])) echo $fella['pseudonym'];?>" id="pseudonym" onkeyup="pseudonym_have();">
               </label>
          </div>
          <br>
               Пол *
               <label>
                    <input type="radio" name="gender" value="m" required <?php if (isset($_GET['id']) and $fella['gender'] == 'm') echo 'checked';?>>М
               </label>
               <label>
                    <input type="radio" name="gender" value="f" required <?php if (isset($_GET['id']) and $fella['gender'] == 'f') echo 'checked';?>>Ж
               </label>
          <br>
          <label>
               Дата рождения
               <input type="date" name="dob" value="<?php if (isset($_GET['id'])) echo $fella['dob']; ?>">
          </label>
          <br>
          <label>
               Информация
               <textarea name="about"><?php if (isset($_GET['id'])) echo $fella['about']; ?></textarea>
          </label>
          <br>
          <div class="bordered">
               <b>Бэнды:</b>
                    <input type="button" id="add" onclick="return add_new_band();" value="Добавить бэнд">
                    <table id="table_bands">
                    <?php if (isset($_GET['id'])) {
                         $fella_id = $_GET['id'];
                         $query = sprintf("SELECT band_id FROM link_fellas_bands WHERE fella_id=$fella_id");
                              $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
                         $n = mysqli_num_rows($result);
                         if ($n != 0) {
                              $item_inputs = array();
                              for ($i = 0; $i < $n; $i++) {
                                 $row = mysqli_fetch_assoc($result);
                                 $item_inputs[] = $row;
                              }
                              for ($k = 0; $k < $n; $k++) {
                                   if (!isset($a)) $a = 1; else $a++;
                                   $input_item_n = $a.'_defined';
                                   $delete_action = "$('#tr_band_".$input_item_n."').remove();";
                                   $c = bands_get($link, $item_inputs[$k]['band_id']);
                                   $who = $c['name'];
                                   echo '<tr id="tr_band_'.$input_item_n.'">
                                   <td><select name="input_bands[]" required="required" style="width: -webkit-fill-available;">
                                        <option selected value="'.$item_inputs[$k]['band_id'].'">'.$who.'</option></select></td>
                                   <td><a style="cursor:pointer;" onclick="'.$delete_action.'">Удалить</a></td></tr>';
                              }
                              unset($a);
                         }
                    } ?>
                         
                    </table>
          </div>
          <div class="bordered">
               <b>Инструменты:</b>
                    <input type="button" id="add" onclick="return add_new_instrument();" value="Добавить инструмент">
                    <table id="table_instruments">
                    <?php if (isset($_GET['id'])) {
                         $fella_id = $_GET['id'];
                         $query = sprintf("SELECT instrument_id FROM link_fellas_instruments WHERE fella_id=$fella_id");
                              $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
                         $n = mysqli_num_rows($result);
                         if ($n != 0) {
                              $item_inputs = array();
                              for ($i = 0; $i < $n; $i++) {
                                 $row = mysqli_fetch_assoc($result);
                                 $item_inputs[] = $row;
                              }
                              for ($k = 0; $k < $n; $k++) {
                                   if (!isset($a)) $a = 1; else $a++;
                                   $input_item_n = $a.'_defined';
                                   $delete_action = "$('#tr_instrument_".$input_item_n."').remove();";
                                   $c = instruments_get($link, $item_inputs[$k]['instrument_id']);
                                   $who = $c['instrument'];
                                   echo '<tr id="tr_instrument_'.$input_item_n.'">
                                   <td><select name="input_instruments[]" required="required" style="width: -webkit-fill-available;">
                                        <option selected value="'.$item_inputs[$k]['instrument_id'].'">'.$who.'</option></select></td>
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
               <input type="tel" name="phone" value="<?php if (isset($_GET['id'])) echo $fella['phone']; ?>" pattern="^[0-9]+$">
          </label>
          <br>
          <label>
               Телефон (доп.)
               <input type="tel" name="phone2" value="<?php if (isset($_GET['id'])) echo $fella['phone2']; ?>" pattern="^[0-9]+$">
          </label>
          <br>
          <label>
               Электропочта
               <input type="email" name="email" value="<?php if (isset($_GET['id'])) echo $fella['email']; ?>">
          </label>
          <br>
          <label>
               Сайт
               <input type="url" name="site" value="<?php if (isset($_GET['id'])) echo $fella['site']; ?>">
          </label>
          <br>
          <label>
               Vk
               <input type="url" name="vk_link" value="<?php if (isset($_GET['id'])) echo $fella['vk_link']; ?>">
          </label>
          <br>
          <label>
               Instagram
               <input type="url" name="instagram_link" value="<?php if (isset($_GET['id'])) echo $fella['instagram_link']; ?>">
          </label>
          <br>
          <label>
               Facebook
               <input type="url" name="fb_link" value="<?php if (isset($_GET['id'])) echo $fella['fb_link']; ?>">
          </label>
          <br>
          <label>
               Twitter
               <input type="url" name="twitter_link" value="<?php if (isset($_GET['id'])) echo $fella['twitter_link']; ?>">
          </label>
          <br>
          <input type="submit" value="Сохранить">
     </form>
</div>