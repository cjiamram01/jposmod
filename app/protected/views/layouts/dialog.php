<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta charset="utf-8" />

    <?php
    // css
      $strPath= Yii::app()->baseUrl;

    echo CHtml::cssFile($strPath.'/css/bootstrap.css');
    echo CHtml::cssFile($strPath.'/css/bootstrap-theme.css');
    echo CHtml::cssFile($strPath.'/css/ui-lightness/jquery-ui-1.10.3.custom.css');
    echo CHtml::cssFile($strPath.'/css/screen.css');  
    echo CHtml::cssFile($strPath.'/css/jquery.treeview.css');
 

    // js
    echo CHtml::scriptFile($strPath.'/js/jquery-2.0.3.js');
    echo CHtml::scriptFile($strPath.'/js/bootstrap.js');
    echo CHtml::scriptFile($strPath.'/js/jquery-ui-1.10.3.custom.js');
    Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');
    Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery.treeview.js');
    Yii::app()->clientScript->registerScriptFile($strPath.'/js/jQueryRotateCompressed.2.1.js');
    Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery.jsontreeviewer.js');


    ?>

  </head>
  <body style="margin: 0px;">
    <div class="content" style="padding: 10px;">
      <?php echo $content; ?>
    </div>
  </body>
</html>

