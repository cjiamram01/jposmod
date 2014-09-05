<script type="text/javascript">
  function chooseRecord(receive_id) {
   

    window.opener.modifyReceived(receive_id);
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกใบรับสินค้า</div>
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
                'name' => 'detail',
                'type' => 'raw',
                'value' => 'CHtml::link($data->detail, "#", array(
							  "onclick" => "chooseRecord(\'$data->id\')"
						))',
                'htmlOptions' => array(
                    'align' => 'center',
                    'width' => '100px'
                )
            ),
            'po_no',
            'transport_supplier',
           
            //'order_date',
              array(
            'name'=>'receive_date',
            'value'=>"Yii::app()->dateFormatter->formatDateTime(\$data->receive_date, 'medium', 'short')",
            'filter'=>false, // Set the filter to false when date range searching
        ),

         

        )
    ));
    ?>
  </div>
</div>

