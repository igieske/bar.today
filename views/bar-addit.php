<script type="text/javascript">
     function OnOrOff(toggle, opened, closed, inputopened, inputclosed) { // открываем поля, день рабочий
          toggle = document.getElementById(toggle);
          opened = document.getElementById(opened);
          closed = document.getElementById(closed);
          inputopened = document.getElementById(inputopened);
          inputclosed = document.getElementById(inputclosed);
          if (toggle.checked) {
               closed.style.display = "none";
               opened.style.display = "block";
               inputopened.required = "required";
               inputclosed.required = "required";
          }
          else {
               closed.style.display = "block";
               opened.style.display = "none";
               inputopened.required = "";
               inputclosed.required = "";
               inputopened.value = "";
               inputclosed.value = "";
          }
     }
</script>
<div>
     <form method="post" action="index.php?action=<?=$_GET['action']?><?php if (isset($_GET['id'])) echo '&id='.$_GET['id'];?>">
          <div class="bordered">
               <label>
                    Название бара *
                    <input type="text" name="name" value="<?php if (isset($_GET['id'])) echo $bar['name']; ?>" autofocus required> 
               </label>
               <br>
               <label>
                    Синоним
                    <input type="text" name="name2" value="<?php if (isset($_GET['id'])) echo $bar['name2']; ?>"> 
               </label>
               <br>
               <label>
                    Синоним 2
                    <input type="text" name="name3" value="<?php if (isset($_GET['id'])) echo $bar['name3']; ?>"> 
               </label>
               <br>
               <label>
                    Самоназвание заведения (тип)
                    <input type="text" name="type_self" value="<?php if (isset($_GET['id'])) echo $bar['type_self']; ?>"> 
               </label>
               <br>
               <label>
                    Сначала самоназвание
                    <input name="first_self" type="checkbox" value="1" <?php if(isset($_GET['id'])) { if ($bar['first_self'] == '1') echo 'checked'; }?>>
               </label>
          </div>
          <br>
          <div class="bordered">
               Улица *
               <?php $query = sprintf("SELECT id, street, city FROM addr_streets ORDER BY city,street ASC");
               $result = mysqli_query($link, $query);
                    if (!$result) die(mysqli_error($link)); ?>
               <select name="addr_street" required>
                    <option selected value="<?php if (isset($_GET['id'])) echo $bar['addr_street']; ?>">
                         <?php if (isset($_GET['id'])) {
                         $street_id = $bar['addr_street'];
                         $query2 = sprintf("SELECT street, city FROM addr_streets WHERE id=$street_id");
                         $result2 = mysqli_query($link, $query2); if (!$result2) die(mysqli_error($link));
                         $street = mysqli_fetch_row($result2);
                         echo $street[0].' ('.$street[1].')'; } ?>
                    </option>
                    <?php while($object = mysqli_fetch_assoc($result)):?>
                    <option value="<?=$object['id']?>"><?=$object['street']?> (<?=$object['city']?>)</option>
                    <?php endwhile;?>
               </select>
               <br>
               <label>
                    Номер дома *
                    <input type="text" name="addr_h" value="<?php if (isset($_GET['id'])) echo $bar['addr_h']; ?>" required>
                    корпус
                    <input type="text" name="addr_h_k" value="<?php if (isset($_GET['id'])) echo $bar['addr_h_k']; ?>" pattern="^[0-9]+$">
                    литера
                    <input type="text" name="addr_h_l" value="<?php if (isset($_GET['id'])) echo $bar['addr_h_l']; ?>" pattern="[А-Я]">
               </label>
               <br>
               Этаж

               <?php for ($i = 0; $i <= 15; $i++) { // количество воможных этажей - цоколь + 15 ?> 
                    <label><input name="floor[]" type="checkbox" <?php if(isset($_GET['id']) and ($bar['addr_floor'] != '')) { if (in_array($i, explode(",", $bar['addr_floor']))) echo 'checked'; } ?> value="<?=$i?>"><?php if ($i==0) echo 'цоколь'; else echo $i; ?></label>
               <?php }
                    ?>
               <hr style="margin:10px 0">
               <div>
                    <?php 
                    if(!isset($_GET['id']) or $bar['opening_hours'] == '') $bar['opening_hours'] = ',,,,,,';
                    foreach (explode(',', $bar['opening_hours']) as $key => $value) {
                         $key++;?>
                         <div class="clearfix">
                              <?php if(isset($_GET['id'])) { if (!empty(opening_hours($bar, $key, 0))) $opened = true; } ?>
                              <input type="checkbox" id="toggle<?=$key?>" class="button-toggle-round" onchange='OnOrOff("toggle<?=$key?>","opened<?=$key?>","closed<?=$key?>","inputopened<?=$key?>","inputclosed<?=$key?>");' <?php if (isset($opened)) echo 'checked';?> >
                              <label for="toggle<?=$key?>"></label>
                              <label for="toggle<?=$key?>"><?php
                                   $days_of_week = array('Пн','Вт','Ср','Чт','Пт','<span class="holyday">Сб</span>','<span class="holyday">Вс</span>');
                                   echo $days_of_week[$key-1];?> –</label>
                              <div id="closed<?=$key?>" <?php if (isset($opened)) echo 'style="display:none;"';?>>Закрыто</div>
                              <div id="opened<?=$key?>" <?php if (!isset($opened)) echo 'style="display:none;"';?>>Открыто
                                   <input id="inputopened<?=$key?>" type="time" name="opening_hours[<?=$key?>][]" min="00:00" max="23:59" value="<?php if (isset($_GET['id'])) echo opening_hours($bar, $key, 0);?>" <?php if (isset($opened)) echo 'required';?>>
                                    – 
                                   <input id="inputclosed<?=$key?>" type="time" name="opening_hours[<?=$key?>][]" min="00:00" max="23:59" value="<?php if (isset($_GET['id'])) echo opening_hours($bar, $key, 1);?>" <?php if (isset($opened)) echo 'required';?>>
                              </div>
                         </div>
                    <?php unset($opened); 
                    } ?>
               </div>
               <label>Комментарий
                    <input type="text" name="opening_hours_comment" value="<?php if (isset($_GET['id'])) echo $bar['opening_hours_comment']; ?>" placeholder="комментарий к режиму"> 
               </label>
               <hr style="margin:10px 0">
               <label>
                    Телефон
                    <input type="text" name="phone" value="<?php if (isset($_GET['id'])) echo $bar['phone']; ?>" pattern="^[0-9]+$"> 
               </label>
                    <label>
                         <input type="text" name="phone_info" value="<?php if (isset($_GET['id'])) echo $bar['phone_info']; ?>" placeholder="комментарий"> 
                    </label>
               <br>
               <label>
                    Телефон №2
                    <input type="tel" name="phone2" value="<?php if (isset($_GET['id'])) echo $bar['phone2']; ?>" pattern="^[0-9]+$"> 
               </label>
                    <label>
                         <input type="text" name="phone2_info" value="<?php if (isset($_GET['id'])) echo $bar['phone2_info']; ?>" placeholder="комментарий"> 
                    </label>
               <br>
               <label>
                    Телефон №3
                    <input type="tel" name="phone3" value="<?php if (isset($_GET['id'])) echo $bar['phone3']; ?>" pattern="^[0-9]+$"> 
               </label>
                    <label>
                         <input type="text" name="phone3_info" value="<?php if (isset($_GET['id'])) echo $bar['phone3_info']; ?>" placeholder="комментарий"> 
                    </label>
               <hr style="margin:10px 0">
               <label>
                    Электропочта
                    <input type="email" name="email" value="<?php if (isset($_GET['id'])) echo $bar['email']; ?>"> 
               </label>
               <br>
               <label>
                    Web-сайт
                    <input type="url" name="site" value="<?php if (isset($_GET['id'])) echo $bar['site']; ?>"> 
               </label>
               <br>
               <label>
                    Vk
                    <input type="url" name="vk_link" value="<?php if (isset($_GET['id'])) echo $bar['vk_link']; ?>">
               </label>
               <br>
               <label>
                    Instagram
                    <input type="url" name="instagram_link" value="<?php if (isset($_GET['id'])) echo $bar['instagram_link']; ?>">
               </label>
               <br>
               <label>
                    Facebook
                    <input type="url" name="fb_link" value="<?php if (isset($_GET['id'])) echo $bar['fb_link']; ?>">
               </label>
          </div>
          <br>
          <div class="bordered">
               <label>
                    Мотто
                    <input type="text" name="motto" value="<?php if (isset($_GET['id'])) echo $bar['motto']; ?>"> 
               </label>
               <br>
               <label>
                    Краткое описание
                    <textarea name="description_brief"><?php if (isset($_GET['id'])) echo $bar['description_brief']; ?></textarea>
               </label>
               <br>
               <label>
                    Описание
                    <textarea name="description"><?php if (isset($_GET['id'])) echo $bar['description']; ?></textarea>
               </label>
          </div>
          <br>
          <label>
               Ценник разливного ОТ (число в рублях)
               <input type="text" name="price_draftbeer_min" value="<?php if (isset($_GET['id'])) echo $bar['price_draftbeer_min']; ?>" pattern="^[0-9]+$"> 
          </label>
          <br>
          <label>
               Ценник разливного ДО (число в рублях)
               <input type="text" name="price_draftbeer_max" value="<?php if (isset($_GET['id'])) echo $bar['price_draftbeer_max']; ?>" pattern="^[0-9]+$"> 
          </label>
          <br>
          <input type="submit" value="Сохранить">
     </form>
</div>