<script type="text/javascript">
    function chooseRecord(branch_id, branch_name) {
        var data = {
            branch_id: branch_id,
            branch_name: branch_name
        };
        window.returnValue = data;
        window.close();
    }
</script>

<div class="alert alert-danger">
    * เลือกรายการสินค้าที่ต้องการ
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model,
    'columns' => array(
        array(
            'name' => 'branch_id',
            'type' => 'raw',
            'value' => 'CHtml::link("เลือกรายการ", "#", array("class" => "btn btn-primary", "onclick" => "chooseRecord(\'$data->branch_id\', \'$data->branch_name\')"))',
            'htmlOptions' => array(
                'align' => 'center',
                'width' => '100px'
            )
        ),
        'branch_name',
        'branch_tel',
        'branch_email',
        'branch_address'
    )
));
?>