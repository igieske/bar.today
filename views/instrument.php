<?php include("views/header.php"); ?>
     <div class="instrument-item">
          <?php $instr = $instrument['instrument'] ?>
          <h2><?=$instr?></h2>
          <h3>
               <?php if ($instr=='вокал') {echo 'Бэнды с <span>вокалом</span>';}
                    else echo '<span>'.$instr.'</span> в бэндах';
               ?>
          </h3>
          <p>
               // список бэндов с инструментом - <?=$instr?>
          </p>
          <h3>
               <?php if ($instr=='вокал') {echo '<span>Поющие</span> феллас';}
                    else echo 'Феллас, лабающие на: <span>'.$instr.'</span>';
               ?>
          </h3>
          <p>
               <?=link_ids($link,'','link_fellas_instruments','fella_id',array('last_name','name'),'instrument_id',$instrument['id'],'Нет таких умельцев.', 'fella.php', 'fellas','')?>
          </p>
     </div>
<?php include("views/footer.php"); ?>