<?php include("views/header.php"); ?>
     <div class="musicstyle-item">
          <?php $st = $musicstyle['musicstyle'] ?>
          <h2><?=$st?></h2>
          <h3>
               <?='Ближайшие кейсы в стиле <span>'.$st.'</span>'?>
          </h3>
          <p>
               // список бэндов с инструментом - <?=$st?>
          </p>
          <h3>
               <?='Бэнды в стиле <span>'.$st.'</span>'?>
          </h3>
          <p>
               <?=link_ids($link,'','link_bands_musicstyles','band_id',array('name'),'musicstyle_id',$musicstyle['id'],'Бэнды не в курсе за этот стиль.', 'band.php', 'bands','')?>
          </p>
     </div>
<?php include("views/footer.php"); ?>