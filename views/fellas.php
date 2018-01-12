<div class="item-head">
     <h2>феллас</h2>
     <span><?php echo 'Всего фэллас: '.sizeof($fellas); ?></span>
     <?=admin_item_add('fella')?>
</div>
<?php foreach($fellas as $a): ?>
<div class="item">
     <p class="name">
          <a href="<?=admin_url_home()?>fella.php?id=<?=$a['id']?>" title="<?=fio($a)?>">
               <?=fio($a)?></a>
          <?=admin_item_edit('fella', $a['id'])?>
     </p>
     
     <?=link_ids($link,'<p>Лабает в ','link_fellas_bands','band_id',array('name'),'fella_id',$a['id'],'', 'band.php', 'bands','</p>')?>
</div>
<?php endforeach ?>