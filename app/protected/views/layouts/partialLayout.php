<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta charset="utf-8" />

    <?php
    $strPath= Yii::app()->baseUrl;
      echo CHtml::cssFile($strPath.'/css/_styles.css');
    ?>

  </head>
  <body style="margin: 0px;">
   
      <div id="content" class="general-style1">
          <?php echo $content; ?>
      </div>
  </body>
</html>

