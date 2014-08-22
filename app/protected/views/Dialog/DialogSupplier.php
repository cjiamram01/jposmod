<script type="text/javascript">
  function chooseRecord(supplier_id, supplier_name) {
    var supplier = {
      supplier_id: supplier_id,
      supplier_name: supplier_name
    };

    window.returnValue = supplier;
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกผู้จัดจำหน่าย</div>
  <div class="panel-body">
    <form name="formSearch" method="POST">
      <div class="input-group">
        <span>ค้นหา: </span>
        <?php
        echo CHtml::textField('search', @$_POST['search'], array(
            'class' => 'form-control',
            'style' => 'width: 300px; margin-right: 5px'
        ));
        ?>
        <a href="#" onclick="formSearch.submit()" class="btn btn-primary">
          <b class="glyphicon glyphicon-search"></b>
          แสดงรายการ
        </a>
      </div>
    </form>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model,
        'columns' => array(
            array(
                'name' => 'farmer_name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->farmer_name, "#", array(
							"onclick" => "chooseRecord(\'$data->farmer_id\', \'$data->farmer_name\')"
						))',
                'htmlOptions' => array(
                    'align' => 'center',
                    'width' => '100px'
                )
            ),
            //'farmer_name',
            'farmer_tel',
            'farmer_address'
        )
    ));
    ?>
  </div>
</div>

