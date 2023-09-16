<?php
   session_start();
   if($_SESSION['count'] <= 0) {
      $_SESSION['count'] = 1;
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="main.css" type="text/css">
      <title>Tasks</title>
   </head>
   <body>
      <form class ='taskAddForm' id='task' action="" method="POST">
         Задача
         <input name = 'taskname' type='text' placeholder='Название'>
         <div class = 'subtasksblock'>
         <?php
            for ($i = 0; $i < $_SESSION['count']; $i++) {
               $subtasksCount = $i + 1;
               echo "
                  Подзадача
                  <input name = 'subtaskName".$subtasksCount."' type = 'text' placeholder = 'Подзадача'>
                  <input name = 'subtaskHours".$subtasksCount."' type='number'>
               ";
            }
         ?>
         </div>

         <input form = 'task' type = 'submit' name = 'addSubtask' value = 'Добавить Подзадачу'>
         <input name = 'saveTask' type = 'submit' value = 'Сохранить Задачу'>
         <input form = 'task' type = 'submit' name='reset' value = 'Новая Задача'>
         
         <?php

            $path = 'tasks';
            $dir = opendir ("$path");
            $fileCounter = 0;

            while (false !== ($file = readdir($dir))) {
               if (strpos($file, '.txt',1) ) {
                  $fileCounter++;
              }
            }            

            if(isset($_POST['saveTask'])) {

               $taskname = $_POST['taskname'];

               $taskFileName = $fileCounter + 1;

               $fd = fopen("tasks/task".$taskFileName.".txt", 'w') or die("Не удалось создать файл");
               $str = "+----+-------+----------------------------------------------------------------------+
   |".$taskname."
+----+-------+----------------------------------------------------------------------+";

               fwrite($fd, $str);
         
               for ($i = 1; $i <= $subtasksCount; $i++) {
               $subtaskname = "subtaskName"."$i";
               $subtaskhours = "subtaskHours"."$i";
               $str = "
_№".$i."|".$_POST[$subtaskhours]."_часы|_".$_POST[$subtaskname]."
+----+-------+----------------------------------------------------------------------+";
                  fwrite($fd, $str);
               }

               fclose($fd);

               $_SESSION['count'] = 1;
               header('Location: index.php');
            }
            if(isset($_POST['addSubtask'])) {
               $_SESSION['count']++;
               header('Location: index.php');
            }
            if(isset($_POST["reset"])) {
               $_SESSION['count'] = 1;
               header('Location: index.php');
            }
         ?>
      </form>
   </body>
</html>