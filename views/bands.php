<div class="item-head">
     <h2>бэнды</h2>
     <span><?php echo 'Всего бэндов: '.sizeof($bands); ?></span>
     <?=admin_item_add('band')?>
</div>
<?php foreach($bands as $a): ?>
<div class="item">
     <p class="name">
          <a href="<?=admin_url_home()?>band.php?id=<?=$a['id']?>" title="<?=$a['name']?>">
               <?=$a['name']?></a>
          <?=admin_item_edit('band', $a['id'])?>
     </p>
     <?=if_not_empty('<p>',$a['description_brief'],'</p>')?>
     <?=link_ids($link,'<p>В стиле ','link_bands_musicstyles','musicstyle_id',array('musicstyle'),'band_id',$a['id'],'', 'musicstyle.php', 'musicstyles','.</p>')?>
     <?=link_ids($link,'<p>Фэллас: ','link_fellas_bands','fella_id',array('name','pseudonym','last_name'),'band_id',$a['id'],'Нет привязанных фэллас.', 'fella.php', 'fellas','</p>')?>
</div>
<?php endforeach ?>