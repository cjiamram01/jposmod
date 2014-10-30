<script type="text/javascript">
  <?php $strPath= Yii::app()->baseUrl; ?>

/*function PopupCenter(url, title, w, h) 
  {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'directories=0,titlebar=0,addressbar=0,scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
        if (window.focus) 
        {
            newWindow.focus();
        }
      return newWindow; 
   }*/


  


</script>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model,
    'columns' => array(
       	array(
            'name' => 'product_code',
            'type' => 'raw',
            'value' => 'CHtml::link("รายการรับ", "#", array("class" => "btn btn-primary", "onclick" => "chooseGR(\'$data->product_code\')"))',
            'htmlOptions' => array(
                'align' => 'center',
                'width' => '100px'
            )
        ),
        'product_code',
        'product_name',
        'product_price',
        'product_cost',
        'product_quantity',
        'product_weight'
    )
));
?>
    