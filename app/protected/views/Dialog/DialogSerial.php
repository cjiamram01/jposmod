<script type="text/javascript">
    function chooseSerial(serial) {
        window.returnValue = serial;
        window.close();
    }
</script>

<div class="alert alert-success">
    <i class="glyphicon glyphicon-ok"></i>
    เลือกรายการ
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $productSerials,
    'columns' => array(
        array(
            'header' => 'serial code',
            'type' => 'raw',
            'value' => 'CHtml::link($data["serial_no"]." ", "#", array("onclick" => "chooseSerial($data[serial_no])", "class" => "btn btn-primary"))'
        ),
        array(
            'header' => 'รหัสสินค้า',
            'name' => 'product_code'
        ),
        array(
            'header' => 'ชื่อสินค้า',
            'name' => 'product_name',
            'htmlOptions' => array(
                'width' => '400px'
            )
        ),
        array(
            'header' => 'วันหมดประกัน',
            'name' => 'product_expire_date'
        ),
        array(
            'header' => 'รหัสบิล',
            'name' => 'bill_sale_id'
        )
    )
)); ?>