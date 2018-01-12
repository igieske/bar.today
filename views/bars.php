<div class="item-head">
     <h2>бары</h2>
     <span><?php echo 'Всего баров: '.sizeof($bars); ?></span>
     <?=admin_item_add('bar')?>
</div>
<?php foreach($bars as $a): ?>
<div class="item">
     <p class="name">
          <a href="<?=admin_url_home()?>bar.php?id=<?=$a['id']?>" title="<?=$a['name']?>"><?=$a['name']?></a>
          <?php if (!empty($a['type_self'])) echo '&equiv;' ?>
          <?=$a['type_self']?>
          <?=admin_item_edit('bar', $a['id'])?>
     </p>
     <p>
          <a href=""><?=bar_address($link, $a['id'], 0)?></a>
     </p>
     <?=if_not_empty('<p>',$a['description_brief'],'</p>')?>
</div>
<?php endforeach ?>