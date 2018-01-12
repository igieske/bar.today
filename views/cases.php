<div class="item-head">
     <h2>кейсы</h2>
     <span><?php echo 'Всего кейсов: '.sizeof($cases); ?></span>
     <?=admin_item_add('case')?>
</div>
<?php foreach($cases as $a): ?>
<div class="item">
     <div class="type-name">
          <div>
               <a href="<?=admin_url_home()?>case.php?id=<?=$a['id']?>" title="<?=$a['title']?>">
                    <p class="type bgc<?=$a['case_type']?>">
                         <?=case_type($link, $a['case_type'])?>
                    </p>
               </a>
          </div>
          <div>
               <?=admin_item_edit('case', $a['id'])?>
          </div>
     </div>
     <?php if(!empty($a['title'])) echo 
     '<a class="case-name name" href="'.admin_url_home().'case.php?id='.$a['id'].'" title="'.$a['title'].'"><p class="cases">'.$a['title'].'</p></a>';?>

     <?php if (file_exists(admin_url_home().poster_path_template($a,1,1).'.jpg'))
          echo '<p><img src="'.admin_url_home().poster_path_template($a,1,1).'.jpg'.'" alt=""></p>'; ?>

     <?=if_not_empty('<p><b>',$a['motto'],'</b></p>')?>
     <b>Место:</b> <?=bar_name($link, $a['bar_id'])?>
     <?=link_ids($link, '<p><b>Бэнды:</b> ', 'link_cases_f_b', 'band_id', array('name'), 'case_id', $a['id'], '', 'band.php', 'bands','</p>') ?>
     <?=link_ids($link, '<p><b>Феллас:</b> ', 'link_cases_f_b', 'fella_id', array('last_name','name'), 'case_id', $a['id'], '', 'fella.php', 'fellas','</p>') ?>
     <?=if_not_empty('<p>',$a['description_brief'],'</p>')?>
     <p>
          <b>Дата:</b> <?=new_time($a['date'],$a['start_time'])?>
          <br>
          <?=entry_price($a)?>
     </p>
</div>
<?php endforeach ?>