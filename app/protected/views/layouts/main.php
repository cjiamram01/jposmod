<!DOCTYPE html>

<?php ini_set("memory_limit", "15000M"); ?>
<?php Yii::app()->timeZone = 'Asia/Bangkok'; ?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <?php
    // css

    $strPath= Yii::app()->baseUrl;
    echo CHtml::cssFile($strPath.'/css/bootstrap.css');
    echo CHtml::cssFile($strPath.'/css/bootstrap-theme.css');
    
    if(Yii::app()->controller->action->id!="ChooseItem")
        echo CHtml::cssFile($strPath.'/css/ui-lightness/jquery-ui-1.10.3.custom.css');
    else
    {
        echo CHtml::cssFile($strPath.'/css/ui-lightness/jquery-ui-1.10.3.custom.css');
        echo CHtml::cssFile($strPath.'/JQueryUI/global.css');
        echo CHtml::cssFile($strPath.'/JQueryUI/shThemePhpBook.css');
    }
    

    //echo CHtml::cssFile($strPath.'/css/jquery.treeview.css');

    if(Yii::app()->controller->action->id!="ChooseItem")
    {
      Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery-2.0.3.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery-ui-1.10.3.custom.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery.treeview.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/js/jQueryRotateCompressed.2.1.js');
      //Yii::app()->clientScript->registerScriptFile($strPath.'/js/jquery.jsontreeviewer.js');
    }
    else

    {
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/plusone.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/jquery-1.7.1.min.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/jquery.ui.core.min.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/jquery.ui.widget.min.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/jquery.ui.position.min.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/jquery.ui.autocomplete.min.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/shCore.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/shBrushPhp.js');
      Yii::app()->clientScript->registerScriptFile($strPath.'/JQueryUI/shBrushXml.js');
    }


    Yii::app()->clientScript->registerScriptFile($strPath.'/js/bootstrap.js');
    Yii::app()->clientScript->registerScriptFile($strPath.'/js/numeral/numeral.js');
  
    ?>



    <style>
      label {
        display: inline-block;
        width: 150px;
        text-align: right;
      }
      .form-control {
        display: inline-block;
      }
      form div {
        padding: 2px;
      }

      /* dropdown */
      .dropdown-submenu {
        position:relative;
      }
      .dropdown-submenu > .dropdown-menu {
        top:0;
        left:100%;
        margin-top:-6px;
        margin-left:-1px;
        -webkit-border-radius:0 6px 6px 6px;
        -moz-border-radius:0 6px 6px 6px;
        border-radius:0 6px 6px 6px;
      }
      .dropdown-submenu:hover > .dropdown-menu {
        display:block;
      }
      .dropdown-submenu > a:after {
        display:block;
        content:" ";
        float:right;
        width:0;
        height:0;
        border-color:transparent;
        border-style:solid;
        border-width:5px 0 5px 5px;
        border-left-color:#cccccc;
        margin-top:5px;
        margin-right:-10px;
      }
      .dropdown-submenu:hover > a:after {
        border-left-color:#ffffff;
      }
      .dropdown-submenu .pull-left{
        float:none;
      }
      .dropdown-submenu.pull-left > .dropdown-menu {
        left:-100%;
        margin-left:10px;
        -webkit-border-radius:6px 0 6px 6px;
        -moz-border-radius:6px 0 6px 6px;
        border-radius:6px 0 6px 6px;
      }

      /* Error */
      .errorSummary {
        padding: 10px;
        border: red 1px solid;
        background: #ffe1e1;
        margin-bottom: 10px;
        -webkit-border-radius:6px 6px 6px 6px;
        -moz-border-radius:6px 6px 6px 6px;
        border-radius:6px 6px 6px 6px;
        color: red;
      }

      /* Table */
      .grid-view .items thead tr th {
        padding: 5px;
        font-size: 14px;
        font-weight: normal;
      }
      .grid-view .items tbody tr td {
        padding: 5px;
        font-size: 14px;
      }
    </style>

    <script>
      var dateBefore=null;
      
      document.ready = function() {
        $(".calendar").datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true,
          dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],   
          monthNamesShort: [
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
          ]  
        });
      }
    </script>

    <title>SUT jPOS 2014 ระบบบริหารงานร้านค้าปลีก ส่ง ทุกรูปแบบ</title>
  </head>

  <body>    
    <div class="nav navbar-inverse" 
				style="padding: 10px; color: #f9f8f7">
  
      <div class="pull-left" style="font-size: 20px">
        <?php $org = Organization::model()->find(); ?>
        <?php echo $org->org_name; ?>
      </div>

      <?php if (Yii::app()->request->cookies['user_id'] != null): ?>
        <div class="pull-right">
          <?php
          $id = Yii::app()->request->cookies['user_id']->value;
          $user = User::model()->findByPk($id);
          ?>
          <label><?php echo @$user->user_name; ?> (<?php echo @$user->user_level; ?>)</label>
          <a href="<?php echo  $strPath; ?>/Site/Logout" class="btn btn-danger" 
             onclick="return confirm('Logout Now')">
						 <b class="glyphicon glyphicon-eject"></b>
            Logout
          </a>
        </div>
      <?php endif; ?>
      <div class="clearfix"></div>
    </div>

    <?php
    if (Yii::app()->request->cookies['user_id'] != null) {
      $this->renderPartial('//site/menu');
    }
    ?>
		
		<?php if (Yii::app()->request->cookies['user_id'] != null): ?>
    <?php echo $content; ?>
    <?php else: ?>
    <?php $this->renderPartial("//site/index"); ?>
    <?php endif; ?>
  </body>
</html>

