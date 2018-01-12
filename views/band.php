<?php include("views/header.php"); ?>
     <div class="band-item">
          <h2><?=$band['name']?></h2>
          
          <span class="admin-item">
               <a href="admin/index.php?action=edit-band&id=<?=$band['id']?>">edit</a>
          </span>   
          
          <?='<h3>'.band_city($link, $band['city_id']).'</h3>'?>
          <?=if_not_empty('<span class="motto"><span class="quote">&ldquo; </span>',$band['motto'],'<span class="quote"> &rdquo;</span></span>')?>
          <?=link_ids($link,'<p><b>Стили:</b> ','link_bands_musicstyles','musicstyle_id',array('musicstyle'),'band_id',$band['id'],'Нет инфы по стилям.', 'musicstyle.php', 'musicstyles','.</p>')?>
          <?=if_not_empty('<p><b>Кратко: </b>',$band['description_brief'],'</p>')?>
          <?=if_not_empty('<p><b>Описание: </b>',$band['description'],'</p>')?>
          <p>
               <?=link_ids_for_bands($link,'<p><b>Фэллас:</b> ',array('name','pseudonym','last_name'),$band['id'],'Нет инфы по фэллас.','.</p>')?>
          </p>
          <p>
          <h3>Контакты</h3>
          <p>
               <?=if_not_empty('<b>Тел.: </b>',$band['phone'],'')?>
                    <?php if(!empty($band['phone']) and !empty($band['phone_info'])) echo $band['phone_info'].'<br>';
                         else if (empty($band['phone'])) echo '';
                         else echo '<br>';
                    ?>
               <?=if_not_empty('<b>Электропочта: </b>',$band['email'],'<br>')?>
               <?=recognize_url('<b>Сайт: </b>',$band['site'],'<br>')?>
               <?=recognize_url('<b>VK: </b>',$band['vk_link'],'<br>')?>
               <?=recognize_url('<b>Instagram: </b>',$band['instagram_link'],'<br>')?>
               <?=recognize_url('<b>Facebook: </b>',$band['fb_link'],'<br>')?>
               <?=recognize_url('<b>Twitter: </b>',$band['twitter_link'],'<br>')?>
          </p>
     </div>
<?php include("views/footer.php"); ?>