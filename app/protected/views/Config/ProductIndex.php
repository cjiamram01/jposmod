   <?php $strPath= Yii::app()->baseUrl; ?>
<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">ข้อมูลสินค้า</div>
  <div class="panel-body">
    <a href="<?php echo $strPath; ?>/Config/ProductForm" class="btn btn-primary">
      <b class="glyphicon glyphicon-plus"></b>
      เพิ่มรายการ
    </a>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model->search(),
        'columns' => array(
            'product_code',
            'product_pack_barcode',
            'product_name',
            'product_price',
            'product_price_send',
            'product_price_per_pack',
            'product_price_buy',
            array(
                'class' => 'CButtonColumn',
                'template' => '{edit} {del}',
                'buttons' => array(
                    'edit' => array(
                        'label' => '
                          <span class="btn btn-success">
                            <b class="glyphicon glyphicon-align-justify"></b>
                            แก้ไข
                          </span>',
                        'url' => 'Yii::app()->createUrl("Config/ProductForm", array(
                          "id" => $data->product_id
                         ))'
                    ),
                    'del' => array(
                        'label' => '
                          <span class="btn btn-danger">
                            <b class="glyphicon glyphicon-minus-sign"></b>
                            ลบ
                          </span>',
                        'url' => 'Yii::app()->createUrl("Config/ProductDelete", array(
                          "id" => $data->product_id
                        ))',
                        'options' => array(
                            'onclick' => 'return confirm("ยืนยันการลบ")'
                        )
                    )
                ),
                'htmlOptions' => array(
                    'width' => '170px',
                    'align' => 'center'
                )
            )
        )
    ));
    ?>
  </div>
</div>

