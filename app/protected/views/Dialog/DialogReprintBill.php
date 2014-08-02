<script type="text/javascript">
  /*function chooseRecord(member_code, member_name) {
    var member = {
      member_code: member_code,
      member_name: member_name
    };

    window.returnValue = member;
    window.close();
  }*/
function chooseBillNo(sale_bill_id){
    var uri = "index.php?r=Dialog/DialogReprintPDF/"+sale_bill_id;
    //var uri = "index.php?r=Dialog/DialogBillSendProduct";
    window.location=uri;
}

function chooseBillAddVat(sale_bill_id){
    var uri = "index.php?r=Dialog/DialogReprintBillVatPDF/"+sale_bill_id;
    //var uri = "index.php?r=Dialog/DialogBillSendProduct";
    window.location=uri;
}

</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกบิล</div>
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
     if($printType==1)
     {
          $this->widget('zii.widgets.grid.CGridView', array(
              'dataProvider' => $model,
              'columns' => array(
                  array(
                      'name' => 'bill_sale_id',
                      'type' => 'raw',
                      'value' => 'CHtml::link($data->bill_sale_id, "#", array(
      							  "onclick" => "chooseBillNo(\'$data->bill_sale_id\')"
      						))',
                      'htmlOptions' => array(
                          'align' => 'center',
                          'width' => '100px'
                      )
                  ),
                   array(
                          'name'=>'member_id',
                          'value'=>'$data->member->member_name',
                  ),
                  'bill_sale_create_date',
                 
                  
              )
          ));
        }
        else
        if($printType==2)
        {

            $this->widget('zii.widgets.grid.CGridView', array(
              'dataProvider' => $model,
              'columns' => array(
                  array(
                      'name' => 'bill_sale_id',
                      'type' => 'raw',
                      'value' => 'CHtml::link($data->bill_sale_id, "#", array(
                      "onclick" => "chooseBillAddVat(\'$data->bill_sale_id\')"
                  ))',
                      'htmlOptions' => array(
                          'align' => 'center',
                          'width' => '100px'
                      )
                  ),
                   array(
                          'name'=>'member_id',
                          'value'=>'$data->member->member_name',
                  ),
                  'bill_sale_create_date',
                 
                  
              )
          ));

        }

    ?>
  </div>
</div>

