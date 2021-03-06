<?php $strPath= Yii::app()->baseUrl; ?>
<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">
    <b class="glyphicon glyphicon-home"></b> คลังสินค้า/สาขา
  </div>
  <div class="panel-body">
    <a href="<?php echo $strPath; ?>/Config/BranchForm" class="btn btn-primary">
      <b class="glyphicon glyphicon-plus"></b>
      เพิ่มรายการ
    </a>
    
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model->search(),
        'summaryText' => 'แสดงผล {start} ถึง {end} จากทั้งหมด {count} รายการ',
        'columns' => array(
            'branch_id',
            'branch_name',
            'branch_tel',
            'branch_email',
            'branch_address',
            'branch_created_date',
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
                        'url' => 'Yii::app()->createUrl("Config/BranchForm", array(
                          "id" => $data->branch_id
                        ))'
                    ),
                    'del' => array(
                        'label' => '
                          <span class="btn btn-danger">
                            <b class="glyphicon glyphicon-minus-sign"></b> 
                            ลบ
                          </span>',
                        'url' => 'Yii::app()->createUrl("Config/BranchDelete", array(
                          "id" => $data->branch_id
                        ))',
                        'options' => array(
                            'onclick' => 'return confirm("ยืนยันการลบ")'
                        )
                    )
                ),
                'htmlOptions' => array(
                    'width' => '160px',
                    'align' => 'center'
                )
            )
        )
    ));
    ?>
  </div>
</div>

