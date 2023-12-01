<div class="embed-container">
    <?php //var_dump($_REQUEST);?>
    <?php if ($_REQUEST['tipo']=="quiz"){?>
    <iframe src="https://cursos.cuyosoft.me/moodle/mod/quiz/view_pp.php?id=<?php echo $_REQUEST['id'];?>" width="800" height="400" style="over-flow: scroll;"> 
    </iframe>
    <?php }?>
    <?php if ($_REQUEST['tipo']=="feedback"){?>
        <iframe src="https://cursos.cuyosoft.me/moodle/mod/feedback/complete_pp.php?id=<?php echo $_REQUEST['id'];?>&courseid=<?php echo $_REQUEST['curso'];?>" width="800" height="400" style="over-flow: scroll;">
         </iframe>
    <?php }?>
    <?php if ($_REQUEST['tipo']=="assign"){?>
        <iframe src="https://cursos.cuyosoft.me/moodle/mod/assign/view_pp.php?id=<?php echo $_REQUEST['id'];?>&courseid=<?php echo $_REQUEST['curso'];?>" width="800" height="400" style="over-flow: scroll;">
         </iframe>
    <?php }?>
</div>