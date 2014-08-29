<script type="text/javascript">
  function chooseRecord(shiping_id) {
   

    window.opener.modifyShiping(shiping_id);
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกรายการ</div>
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
                'name' => 'bill_no',
                'type' => 'raw',
                'value' => 'CHtml::link($data->bill_no, "#", array(
							  "onclick" => "chooseRecord(\'$data->id\')"
						))',
                'htmlOptions' => array(
                    'align' => 'center',
                    'width' => '100px'
                )
            ),
            'customer',
            'detail',
          
              array(
            'name'=>'shiping_date',
            'value'=>"Yii::app()->dateFormatter->formatDateTime(\$data->shiping_date, 'medium', 'short')",
            'filter'=>false, // Set the filter to false when date range searching
        ),

         

        )
    ));
    ?>
  </div>
</div>

