<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">
    <b class="glyphicon glyphicon-list-alt"></b>
    ข้อมูลประเภทสินค้า
  </div>
  <div class="panel-body">
    <a href="index.php?r=Config/GroupProductForm" class="btn btn-primary">
      <u class="glyphicon glyphicon-plus"></u>
      เพิ่มรายการ
    </a>
    
    <?php
    $this->widget("zii.widgets.grid.CGridView", array(
        'dataProvider' => $model->search(),
        'columns' => array(
            array(
                'name' => 'group_product_code',
                'htmlOptions' => array(
                    'width' => '150px',
                    'align' => 'center'
                )
            ),
            array(
                'name' => 'group_product_name',
                'htmlOptions' => array('width' => '300px')
            ),
            'group_product_detail',
            array(
                'class' => 'CButtonColumn',
                'template' => '{edit} {del}',
                'buttons' => array(
                    'edit' => array(
                        'label' => '
                          <span class="btn btn-success">
                            <u class="glyphicon glyphicon-align-justify"></u> 
                            แก้ไข
                          </span>',
                        'url' => 'Yii::app()->createUrl("Config/GroupProductForm", array(
                          "id" => $data->group_product_id
                        ))'
                    ),
                    'del' => array(
                        'label' => '
                          <span class="btn btn-danger">
                            <u class="glyphicon glyphicon-minus-sign"></u> 
                            ลบ
                          </span>',
                        'url' => 'Yii::app()->createUrl("Config/GroupProductDelete", array(
                          "id" => $data->group_product_id
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

