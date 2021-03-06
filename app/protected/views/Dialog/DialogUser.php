<script type="text/javascript">
    function chooseRecord(user_id, user_name) {
        var user = {
            user_id: user_id,
            user_name: user_name
        };
        window.returnValue = user;
        window.close();
    }
</script>

<?php echo CHtml::form(); ?>
<div>
    <span>ค้นหา: </span>
    <?php echo CHtml::textField('search', @$_POST['search']); ?>
    <input type="submit" value="แสดงรายการ" />
</div>
<?php echo CHtml::endForm(); ?>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model,
    'columns' => array(
        array(
            'name' => 'user_name',
            'type' => 'raw',
            'value' => 'CHtml::link("เลือกรายการ", "#", array("class" => "btn btn-primary","onclick" => "chooseRecord(\'$data->user_id\', \'$data->user_name\')"))',
            'htmlOptions' => array(
                'align' => 'center',
                'width' => '100px'
            )
        ),
        'user_name',
        'user_tel'
    )
));
?>
    