<?php include("views/header.php"); ?>
     <div class="bar-item">
          <h2><?php
               bar_name($link, $bar['id']);
               echo $prefix.'<span>'.$bar['name'].'</span>'.$postfix; ?>
          </h2>
          <?php
               if (!empty($bar['name2'])) echo '<h3>/ '.$bar['name2'];
               if (!empty($bar['name3'])) echo ' / '.$bar['name3'].'</h3>'; else echo '</h3>';
          ?>
          <?=if_not_empty('<span class="motto"><span class="quote">&ldquo; </span>',$bar['motto'],'<span class="quote"> &rdquo;</span></span> ')?>
          
          <!-- временная кнопка -->
          <span class="admin-item">
               <a href="admin/index.php?action=edit-bar&id=<?=$bar['id']?>">edit</a>
          </span>
          
          <p><b><?=bar_address($link, $bar['id'], 1)?></b><?=bar_address_floor($link, $bar['id'])?></p>

          <?php
			if ($bar['opening_hours'] != 'x,,,,,,') {
                    if (substr($bar['opening_hours'], -6) == ',,,,,,') {
                         echo 'Работает ежедневно '.opening_hours($bar, 1, 0).' – '.opening_hours($bar, 1, 1);
                    } else {
                         $days_of_week = array('Пн','Вт','Ср','Чт','Пт','<span class="holyday">Сб</span>','<span class="holyday">Вс</span>');
                         echo '<div class="opening-hours">';
                         foreach (explode(',', $bar['opening_hours']) as $key => $value) {
                              $key++;
                              echo '<div>';
                                   echo $days_of_week[$key-1].'<hr>';
                                   if (opening_hours($bar, $key, 0) == '') echo '<span style="font-size:29px;color:chocolate;">&times;</span>';
                                   else {
                                        echo '<div>'.opening_hours($bar, $key, 0).'</div>';
                                        echo '<div>'.opening_hours($bar, $key, 1).'</div>';
                                   }
                              echo '</div>';
                         }
                         echo '</div>';
                    }
               }
          ?>
          <?=if_not_empty('<p>Комментарий к графику работы: ',$bar['opening_hours_comment'],'</p>')?>
          <?=if_not_empty('<p><b>Краткое описание: </b>',$bar['description_brief'],'</p>')?>
          <?=if_not_empty('<p>',$bar['description'],'</p>')?>
          <p>
               <?php
                    $txt = 'Пивасик разливной (500ml): ';
                    if (!empty($bar['price_draftbeer_min']) and empty($bar['price_draftbeer_max']))
                         echo $txt.'от '.$bar['price_draftbeer_min'].' руб.';
                    if (!empty($bar['price_draftbeer_min']) and !empty($bar['price_draftbeer_max']))
                         echo $txt.$bar['price_draftbeer_min'].' &ndash; '.$bar['price_draftbeer_max'].' руб.';
                    if (empty($bar['price_draftbeer_min']) and !empty($bar['price_draftbeer_max']))
                         echo $txt.'до '.$bar['price_draftbeer_max'].' руб.';  
               ?>
          </p>
          <h3>Контакты:</h3>
          <p>
               <?=if_not_empty('<b>Тел.: </b>',$bar['phone'],'')?>
                    <?php if(!empty($bar['phone']) and !empty($bar['phone_info'])) echo $bar['phone_info'].'<br>';
                         else if (empty($bar['phone'])) echo '';
                         else echo '<br>';
                    ?>
               <?=if_not_empty('<b>Тел. (доп.) </b>',$bar['phone2'],'')?>
                    <?php if(!empty($bar['phone2']) and !empty($bar['phone2_info'])) echo $bar['phone2_info'].'<br>';
                         else if (empty($bar['phone2'])) echo '';
                         else echo '<br>';
                    ?>
               <?=if_not_empty('<b>Тел. (доп.) </b>',$bar['phone3'],'')?>
                    <?php if(!empty($bar['phone3']) and !empty($bar['phone3_info'])) echo $bar['phone3_info'].'<br>';
                         else if (empty($bar['phone3'])) echo '';
                         else echo '<br>';
                    ?>
               <?=if_not_empty('<b>Электропочта: </b>',$bar['email'],'<br>')?>
               <?=recognize_url('<b>Сайт: </b>',$bar['site'],'<br>')?>
               <?=recognize_url('<b>VK: </b>',$bar['vk_link'],'<br>')?>
               <?=recognize_url('<b>Instagram: </b>',$bar['instagram_link'],'<br>')?>
               <?=recognize_url('<b>Facebook: </b>',$bar['fb_link'],'')?>
          </p>
     </div>
<?php include("views/footer.php"); ?>