<?php include("views/header.php"); ?>
     <div class="case-item">
          <h2><?=$case['title']?></h2>
          
          <span class="admin-item">
               <a href="admin/index.php?action=edit-case&id=<?=$case['id']?>">edit</a>
          </span>   
          
          <p>
               <?php require_once("models/bars.php"); ?>
               Место: <?=bar_name($link, $case['bar_id'])?>
          </p>

          <?php if (file_exists(poster_path_template($case,1,1).'.jpg'))
               echo '<p><img  src="'.poster_path_template($case,1,1).'.jpg'.'" alt=""></p>'; ?>

          <?=link_ids($link, '<p>Выступают бэнды: ', 'link_cases_f_b', 'band_id', array('name'), 'case_id', $case['id'], '', 'band.php', 'bands','.</p>') ?>
          <?=link_ids($link, '<p>Выступают фэллас: ', 'link_cases_f_b', 'fella_id', array('name', 'last_name'), 'case_id', $case['id'], '', 'fella.php', 'fellas','.</p>') ?>
         
          <?=if_not_empty('<p><b>',$case['motto'],'</b></p>')?>
          <?=if_not_empty('<p><b>Краткое описание: </b>',$case['description_brief'],'</p>')?>
          <?=if_not_empty('<p><b>Описание: </b>',$case['description'],'</p>')?>
          <p>
               <b>Дата:</b> <?=new_time($case['date'],$case['start_time'])?>
               <br>
               <?=entry_price($case)?>
          </p>
     </div>
<?php include("views/footer.php"); ?>