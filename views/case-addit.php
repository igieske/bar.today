<script type="text/javascript">
     function OnOrOff(cb, cat) { // дизаблим поля, если галка стоит
          cb = document.getElementById(cb);
          cat = document.getElementById(cat);
          if (cb.checked) cat.disabled = true;
          else cat.disabled = false;
     }
</script>
<?php // достаём списки бэндов и фэллас
     function bands_list($link) {
          $query = sprintf("SELECT id, name FROM bands ORDER BY name ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.$object['name'].'</option>';
          endwhile;
     }     
     function fellas_list($link) {
          $query = sprintf("SELECT id, last_name, pseudonym, name FROM fellas ORDER BY last_name ASC");
          $result = mysqli_query($link, $query);
               if (!$result) die(mysqli_error($link));
          while($object = mysqli_fetch_assoc($result)):
               echo '<option value='.$object['id'].'>'.fio2($object).'</option>';
          endwhile;
     }
?>
<script type="text/javascript">
     // кнопка "добавить фэлла"
     var total_f_b = 0;
     var fellas_list = "<?=fellas_list($link)?>";
     function add_new_fella(){
          total_f_b++;
          $('<tr>')
          .attr('id','tr_fella_'+total_f_b)
          .append (
               $('<td>')
               .css({width:'45px'})
               .append (
                    $('<span>Фэлла</span>')
               )
          )
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
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_fella_'+total_f_b+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_f_b');                
     }
     // кнопка "добавить бэнд"
     //var total_bands = 0;
     var bands_list = "<?=bands_list($link)?>";
     function add_new_band(){
          total_f_b++;
          $('<tr>')
          .attr('id','tr_band_'+total_f_b)
          .append (
               $('<td>')
               .css({width:'45px'})
               .append (
                    $('<span>Бэнд</span>')
               )
          )
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
                    $('<a style="cursor:pointer;" onclick="$(\'#tr_band_'+total_f_b+'\').remove();"">Удалить</a>')
               )
          )
          .appendTo('#table_f_b');                
     }
</script>

<div class="addit-item">
     <form enctype="multipart/form-data" method="post" action="index.php?action=<?=$_GET['action']?><?php if (isset($_GET['id'])) echo '&id='.$_GET['id'];?>">
          <label>
          Бар *
               <?php $query = sprintf("SELECT id, name, type_self FROM bars ORDER BY id ASC");
               $result = mysqli_query($link, $query);
                    if (!$result) die(mysqli_error($link)); ?>
               <select name="bar_id" required autofocus>
                    <option selected value="<?php if (isset($_GET['id'])) echo $case['bar_id']; ?>">
                         <?php if (isset($_GET['id'])) {
                         $bar_id = $case['bar_id'];
                         $query2 = sprintf("SELECT name, type_self FROM bars WHERE id=$bar_id");
                         $result2 = mysqli_query($link, $query2); if (!$result2) die(mysqli_error($link));
                         $bar = mysqli_fetch_row($result2);
                         echo $bar[0].', '.$bar[1]; } ?>
                    </option>
                    <?php while($object = mysqli_fetch_assoc($result)):?>
                    <option value="<?=$object['id']?>"><?=$object['name'].', '.$object['type_self']?></option>
                    <?php endwhile;?>
               </select>
          </label>
          <label>
               Дата *
               <input type="date" name="date" value="<?php if (isset($_GET['id'])) echo $case['date']; ?>" required> 
          </label>
          <br>
          <div class="bordered">
               <label>
               Тип встречи *
                    <?php $query = sprintf("SELECT id, case_type FROM cases_types ORDER BY id ASC");
                    $result = mysqli_query($link, $query);
                         if (!$result) die(mysqli_error($link)); ?>
                    <select name="case_type" required>
                         <?php if (isset($_GET['id'])) {
                              echo '<option value="'.$case['case_type'].'" selected>';
                              $case_type = $case['case_type'];
                              $query2 = sprintf("SELECT case_type FROM cases_types WHERE id=$case_type");
                              $result2 = mysqli_query($link, $query2); if (!$result2) die(mysqli_error($link));
                              $case_type = mysqli_fetch_row($result2);
                              echo $case_type[0];
                              echo '</option>';
                         }?>
                         <?php while($object = mysqli_fetch_assoc($result)):?>
                         <option value="<?=$object['id']?>"><?=$object['case_type']?></option>
                         <?php endwhile;?>
                    </select>
               </label>
               <label>
                    Время начала встречи
                    <input type="time" name="start_time" value="<?php if (isset($_GET['id'])) echo $case['start_time']; ?>"> 
               </label>
               <br>
               <div class="bordered light">
                    <b>Выступают (вместе):</b>
                    <input type="button" id="add" onclick="return add_new_fella();" value="Добавить фэлла">
                    <input type="button" id="add" onclick="return add_new_band();" value="Добавить бэнд">
                    <table id="table_f_b">
                    <?php if (isset($_GET['id'])) {
                         $case_id = $_GET['id'];
                         $query = sprintf("SELECT fella_id, band_id FROM link_cases_f_b WHERE case_id=$case_id ORDER BY id ASC");
                              $result = mysqli_query($link, $query); if (!$result) die(mysqli_error($link));
                         $n = mysqli_num_rows($result);
                         if ($n != 0) {
                              $case_inputs = array();
                              for ($i = 0; $i < $n; $i++) {
                                 $row = mysqli_fetch_assoc($result);
                                 $case_inputs[] = $row;
                              }
                              for ($k = 0; $k < $n; $k++) {
                                   if (!empty($case_inputs[$k]['fella_id'])) {
                                        $input_item = 'fella';
                                        $input_item_row = 'fella_id';
                                        $input_item_name = 'Фэлла';
                                        if (!isset($a)) $a = 1; else $a++;
                                        $input_item_n = $a.'_defined';
                                        $delete_action = "$('#tr_fella_".$input_item_n."').remove();";
                                        $c = fellas_get($link, $case_inputs[$k]['fella_id']);
                                        $who = fio2($c);
                                   }
                                   else if (!empty($case_inputs[$k]['band_id'])) {
                                        $input_item = 'band';
                                        $input_item_row = 'band_id';
                                        $input_item_name = 'Бэнд';
                                        if (!isset($b)) $b = 1;
                                             else $b++;
                                        $input_item_n = $b.'_defined';
                                        $delete_action = "$('#tr_band_".$input_item_n."').remove();";
                                        $c = bands_get($link, $case_inputs[$k]['band_id']);
                                        $who = $c['name'];
                                   }
                                   echo '<tr id="tr_'.$input_item.'_'.$input_item_n.'">
                                   <td style="width: 45px;"><span>'.$input_item_name.'</span></td>
                                   <td><select name="input_'.$input_item.'s[]" required="required" style="width: -webkit-fill-available;">
                                        <option selected value="'.$case_inputs[$k][$input_item_row].'">'.$who.'</option></select></td>
                                   <td><a style="cursor:pointer;" onclick="'.$delete_action.'">Удалить</a></td></tr>';
                              }
                         }
                    } ?>
                         
                    </table>
               </div>
               <br>
               <div class="bordered light">
                    <label>
                         Название кейса
                         <input type="text" name="title" value="<?php if (isset($_GET['id'])) echo $case['title']; ?>"> 
                    </label>
                    <br>
                    <label>
                         Мотто
                         <input type="text" name="motto" value="<?php if (isset($_GET['id'])) echo $case['motto']; ?>"> 
                    </label>
                    <br>
                    <label>
                         Краткое описание
                         <textarea name="description_brief"><?php if (isset($_GET['id'])) echo $case['description_brief']; ?></textarea>
                    </label>
                    <br>
                    <label>
                         Описание
                         <textarea name="description"><?php if (isset($_GET['id'])) echo $case['description']; ?></textarea>
                    </label>
                    <br>
                    <label>
                         Однодневная туса
                         <input id="cb1" onchange='OnOrOff("cb1", "cat1");' type="checkbox" name="one_day_or" value="1"
                         <?php if(isset($_GET['id'])) { if ($case['one_day_or'] == "1" or $case['one_day_or'] == "0") echo 'checked'; } else echo 'checked' ?>>
                    </label>
                    <label>
                         Количество дней
                         <input id="cat1" type="text" name="one_day_or" value="<?php if (isset($_GET['id']) and ($case['one_day_or']) != "0") echo $case['one_day_or']; else echo '1'; ?>" pattern="^[ 0-9]+$"
                              <?php if (isset($_GET['id'])) {if ($case['one_day_or'] == "1" or $case['one_day_or'] == "0") echo 'disabled'; } else echo 'disabled' ?>>
                    </label>
               </div>
               <br>
               <label>
                    Вход сводбодный
                    <input id="cb2" onchange='OnOrOff("cb2", "cat2");' type="checkbox" name="entry_price" value="0"
                    <?php if(isset($_GET['id'])) { if ($case['entry_price'] == "0") echo 'checked'; }?>>
               </label>
               <label>
                    Стоимость, руб.
                    <input id="cat2" type="text" name="entry_price" value="<?php if (isset($_GET['id'])) echo $case['entry_price']; ?>" pattern="^[ 0-9]+$"
                         <?php if (isset($_GET['id'])) {if ($case['entry_price'] == "0") echo 'disabled'; } ?> placeholder="не задано"> 
               </label>
               <br>
               Изображение для афиши
               <input type="file" name="poster" accept="image/jpeg,image/png">
               <?php if (isset($_GET['id']) && file_exists(admin_url_home().poster_path_template($case,1,1).'.jpg'))
                    echo '<br><img  src="'.admin_url_home().poster_path_template($case,1,1).'.jpg'.'" alt="">'; ?>
               <br>
          </div>
          <br>
          <input type="submit" value="Сохранить">
     </form>
</div>