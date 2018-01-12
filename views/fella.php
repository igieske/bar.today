<?php include("views/header.php"); ?>
     <div class="fella-item">
          <h2><span><?=$fella['name']?><?=if_not_empty(' </span>',$fella['pseudonym'],'<span>')?> <?=$fella['last_name']?></span></h2>
             
          <span class="admin-item">
               <a href="admin/index.php?action=edit-fella&id=<?=$fella['id']?>">edit</a>
          </span>   
          
               <?php if (!empty ($fella['dob'])) echo '<p><b>День рождения:</b> '.new_time($fella['dob'],'').'</p>'; ?>

          <?=if_not_empty('<p><b>О фелла: </b>',$fella['about'],'</p>')?>

          <p>
               <?=link_ids($link,'Лабает в ','link_fellas_bands','band_id',array('name'),'fella_id',$fella['id'],'Лабает сам по себе.', 'band.php', 'bands','.')?>
          </p>
          <p>
               <?=link_ids($link,'Инструменты &ndash; ','link_fellas_instruments','instrument_id',array('instrument'),'fella_id',$fella['id'],'Инструментов не знает.', 'instrument.php', 'instruments','.')?>
          </p>
          <p>
          <h3>Контакты:</h3>
          <p>
               <?=if_not_empty('<b>Тел.: </b>',$fella['phone'],'<br>')?>
               <?=if_not_empty('<b>Тел. (доп.): </b>',$fella['phone2'],'<br>')?>
               <?=if_not_empty('<b>Электропочта: </b>',$fella['email'],'<br>')?>
               <?=recognize_url('<b>Сайт: </b>',$fella['site'],'<br>')?>
               <?=recognize_url('<b>VK: </b>',$fella['vk_link'],'<br>')?>
               <?=recognize_url('<b>Instagram: </b>',$fella['instagram_link'],'<br>')?>
               <?=recognize_url('<b>Facebook: </b>',$fella['fb_link'],'<br>')?>
               <?=recognize_url('<b>Twitter: </b>',$fella['twitter_link'],'<br>')?>
          </p>
     </div>
<?php include("views/footer.php"); ?>