<script type="text/javascript">
    document.ready = function() {
        $("#from").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true,
            changeMonth: true
        });
        $("#to").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true,
            changeMonth: true
        });
    }
    
    function browseMember() {
        var uri = "<?php echo $this->createUrl('Dialog/DialogMember'); ?>";
        var options = "dialogWidth=800px; dialogHeight=600px";
        var w = window.showModalDialog(uri, null, options);
        
        if (w != null) {
            $("#member_code").val(w.member_code);
            $("#member_name").val(w.member_name);
            $("#hidden_member_code").val(w.member_code);
        }
    }
    
    function getBillDrop() {
        $.ajax({
            url: "<?php echo $this->createUrl("Basic/BillDropGet"); ?>",
            type: "POST",
            data: $("#formData").serialize(),
            success: function(data) {
                if (data != null) {
                    refreshData();
                }
            }
        });
    }
    
    function printBillDrop() {
        // send data to session
        var uri = "<?php echo $this->createUrl("Dialog/DialogBillDrop"); ?>";
        var options = "dialogWidth=900px; dialogHeight=600px";
           
        $.ajax({
            url: '<?php echo $this->createUrl("Basic/BillDropTemp"); ?>',
            type: 'POST',
            data: $("#formData").serialize(),
            success: function(data) {
                if (data == 'complete') {
                    window.showModalDialog(uri, null, options);
                    refreshData();
                }
            },
            error: function(data) {
                alert('ERROR ' + data);
            }
        });
    }
    
    function refreshData() {
        document.form1.submit();
    }
    
    function cancelBillDrop() {
        $.ajax({
            url: "<?php echo $this->createUrl("Basic/BillDropCancel"); ?>",
            type: "POST",
            data: $("#formData").serialize(),
            success: function(data) {
                if (data != null) {
                    refreshData();
                }
            }
        });
    }
    
    function deleteBillDrop() {
	    $.ajax({
            url: "<?php echo $this->createUrl("Basic/BillDropDelete"); ?>",
            type: "POST",
            data: $("#formData").serialize(),
            success: function(data) {
                if (data != null) {
                    refreshData();
                }
            }
        });
    }
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">พิมพ์ใบวางบิล</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array(
                'name' => 'form1'
            )
        ));
        ?>
        <div>
            <label>จากวันที่: </label>
            <input type="text" name="from" id="from" class="form-control" style="width: 200px" value="<?php echo Util::mysqlToThaiDate($from); ?>" />

            <label>ถึงวันที่: </label>
            <input type="text" name="to" id="to" class="form-control" style="width: 200px" value="<?php echo Util::mysqlToThaiDate($to); ?>" />
        </div>
        <div>
            <div class="form-search">
            <label>สมาชิก</label>
            <input type="text" name="member_code" id="member_code" class="form-control" style="width: 150px" value="<?php echo $member_code; ?>" />
            <input type="text" name="member_name" id="member_name" value="<?php echo $member_name; ?>" class="form-control disabled" style="width: 362px" readonly="readonly" />
            <a href="#" class="btn btn-primary" onclick="browseMember()">
                <i class="glyphicon glyphicon-search"></i>
                ...
            </a>
            </div>
        </div>
        <div>
            <label>สถานะบิล</label>
            <?php echo CHtml::radioButton('bill_status', $bill_status == 'all' || empty($bill_status), array('value' => 'all')); ?> ทุกสถานะ
            <?php echo CHtml::radioButton('bill_status', $bill_status == 'no', array('value' => 'no')); ?> ยังไม่วางบิล
            <?php echo CHtml::radioButton('bill_status', $bill_status == 'drop_no', array('value' => 'drop_no')); ?> วางบิลแล้ว รอชำระ
            <?php echo CHtml::radioButton('bill_status', $bill_status == 'drop_pay', array('value' => 'drop_pay')); ?> วางบิลแล้ว ชำระแล้ว
        </div>
        <div>
            <label></label>
            <a href="#" class="btn btn-success" onclick="document.form1.submit()">
                <i class="glyphicon glyphicon-ok"></i>
                แสดงรายการ
            </a>
        </div>
        <?php $this->endWidget(); ?>
        <hr />

        <form id="formData">
            <div>
                <a href="#" class="btn btn-primary" onclick="getBillDrop()">
                  <i class="glyphicon glyphicon-list-alt"></i>
                  รับบิล
                </a>
                <a href="#" class="btn btn-primary" onclick="printBillDrop()">
                  <i class="glyphicon glyphicon-print"></i>
                  พิมพ์ใบวางบิล
                </a>
                <a href="#" class="btn btn-warning" onclick="cancelBillDrop()">
                  <i class="glyphicon glyphicon-remove"></i>
                  ยกเลิกบิล
                </a>
                |
                <a href="#" class="btn btn-danger" onclick="deleteBillDrop()">
                		<b class="glyphicon glyphicon-trash"></b>
                		ลบบิลออกจากระบบ
                </a>
            </div>
            <?php
            if (!empty($dataProvider)) {
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $dataProvider,
                    'selectableRows' => 2,
                    'columns' => array(
                        array(
                            'class' => 'CCheckBoxColumn',
                            'id' => 'bill_sale_id',
                            'htmlOptions' => array(
                                'width' => '30px',
                                'align' => 'center'
                            )
                        ),
                        array(
                            'name' => 'bill_sale_id',
                            'htmlOptions' => array(
                                'width' => '80px',
                                'align' => 'center'
                            )
                        ),
                        array(
                            'header' => 'จำนวนยอด',
                            'type' => 'raw',
                            'value' => '$data->getSum()',
                            'htmlOptions' => array(
                                'width' => '100px',
                                'align' => 'right'
                            )
                        ),
                        array(
                            'name' => 'bill_sale_created_date',
                            'htmlOptions' => array(
                                'width' => '150px',
                                'align' => 'center'
                            )
                        ),
                        array(
                            'name' => 'bill_sale_drop_bill_date',
                            'htmlOptions' => array(
                                'width' => '150px',
                                'align' => 'center'
                            )
                        ),
                        array(
                            'name' => 'bill_sale_status',
                            'htmlOptions' => array(
                                'width' => '80px',
                                'align' => 'center'
                            ),
                            'value' => '$data->getStatus()'
                        ),
                        array(
                            'name' => 'user_id',
                            'value' => '@$data->user->user_name'
                        ),
                        array(
                            'name' => 'bill_sale_pay_date',
                            'htmlOptions' => array(
                                'width' => '150px',
                                'align' => 'center'
                            )
                        )
                    )
                ));
            }
            ?>
            <input type="hidden" name="hidden_member_code" id="hidden_member_code" value="<?php echo $member_code; ?>" />
        </form>
    </div>
</div>