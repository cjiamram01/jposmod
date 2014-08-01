<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
    body, table {
        font-family: Tahoma;
        font-size: 15px;
    }
    table {
        border-collapse: collapse;
    }
    table tr th, td {
        border: #999 solid 1px;
        padding: 5px;
    }
    table tr th{
        background-color: #ddd;
    }
</style>

<script type="text/javascript">
    $(function() {
        $("input[name=date_find]").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy'
        });
    });
    
    function printReport() {
	    var url = 'index.php?r=Dialog/ReportSalePerDayPdf';
	    var options = 'dialogWidth=950px; dialogHeight=600px';
	    
	    window.showModalDialog(url, null, options);
    }
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">รายงานยอดขายประจำวัน</div>
    <div class="panel-body">
    	<form name="form1" method="post">
        <?php  
        $date_find = Util::nowThai();
        
        if (!empty($_POST)) {
	        $date_find = $_POST['date_find'];
        }
        ?>
        <div>
        	<label style="width: 80px">เลือกสาขา</label>
        	<?php echo CHtml::dropdownList('branch_id', @$branch_id, Branch::getOptions(), array(
        		'class' => 'form-control',
        		'style' => 'width: 200px'
        	)); ?>
        </div>
        <div>
            <label style="width: 80px">เลือกวันที่</label>
            <input type="text" name="date_find" class="form-control" style="width: 200px" value="<?php echo $date_find; ?>" />
            
            <label style="width: 120px">เงื่อนไขการขาย</label>
            <span class="alert alert-success">
            	<input type="checkbox" 
            		name="sale_condition_cash" 
            		value="cash" 
            		<?php echo $checked_cash; ?> /> 
            	<span style="margin-right: 20px">เงินสด</span>
            		
            	<input type="checkbox" 
            		name="sale_condition_credit" 
            		value="credit" 
            		<?php echo $checked_credit; ?> /> 
            	<span>เงินเชื่อ</span>
            </span>
            
            <label style="width: 120px">เงื่อนไขส่วนลด</label>
            <span class="alert alert-success">
            	<input type="checkbox" name="has_bonus_yes" value="yes" <?php echo $checked_bonus_yes; ?> />
            	<span style="padding-right: 20px">มีส่วนลด</span>
            	
            	<input type="checkbox" name="has_bonus_no" value="no" <?php echo $checked_bonus_no; ?> />
            	<span>ไม่มีส่วนลด</span>
            </span>
        </div>
        <div>
            <label style="width: 80px"></label>

            <a href="#" class="btn btn-primary" onclick="document.form1.submit();">
                <i class="glyphicon glyphicon-ok"></i>
                แสดงรายงาน
            </a>
        </div>
    	</form>

		<?php if (!empty($_POST)) : ?>
        	<div style="text-align: right; padding-bottom: 5px;">
        		<a href="#" class="btn btn-primary" onclick="printReport()">
        			<span class="glyphicon glyphicon-print"></span>
        			พิมพ์รายงาน
        		</a>
        	</div>
        	
            <table border="1" width="100%">
            	<thead>
	                <tr>
	                    <th width="40px">ลำดับ</th>
	                    <th width="80px">เลขที่บิล</th>
	                    <th width="100px">รหัสสินค้า</th>
	                    <th>รายการสินค้า</th>
	                    <th width="50px">จำนวน</th>
	                    <th width="160px">ราคาจำหน่าย/หน่วย</th>
	                    <th width="95px">จำหน่ายจริง</th>
	                    <th width="50px">ส่วนลด</th>
	                    <th width="80px">สถานะบิล</th>
	                    <th width="90px">จำนวนเงิน</th>
	                </tr>
            	</thead>
                
                <tbody>
                <?php
                $i = 1;
                $sum = 0;
                
                foreach ($result as $value) :
                    $sum += $value['bill_sale_detail_price'] * $value['bill_sale_detail_qty'];
                    ?>
                    <tr style="background-color: #fafafa;">
                        <td style="text-align: right;">
                        	<?php echo $i++; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $value['bill_sale_id']; ?>
                        </td>                        
                        <td style="text-align: center">
                        	<?php echo $value['bill_sale_detail_barcode']; ?>
                        </td>
                        <td>
                            <?php echo $value['product_name']; ?>
                        </td>
                        <td style="text-align: right">
                        	<?php echo number_format($value['bill_sale_detail_qty']); ?>
                        </td>
                        <td style="text-align: right">
                        	<?php echo number_format($value['product_price']); ?>
                        </td>
                        <td style="text-align: right">
                        	<?php echo number_format($value['bill_sale_detail_price']); ?>
                        </td>
                        <td style="text-align: right">
                        	<?php
                        	$change = ($value['product_price'] - $value['bill_sale_detail_price']);
                        	
                        	if ($change == 0) {
	                        	echo '&nbsp;';
                        	} else {
	                        	echo number_format($change);
                        	}
                        	?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $value['bill_sale_status']; ?>
                        </td>
                        <td style="text-align: right;">
                            <?php echo number_format($value['bill_sale_detail_price'] * $value['bill_sale_detail_qty']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
				</tbody>
                
                <tfoot>
	                <tr>
	                    <td colspan="9" style="text-align: left; padding-right: 10px; background-color: #ddd;">
	                        <span style="font-weight: bold; font-size: 13px;">รวม : </span>
	                    </td>
	                    <td style="text-align: right; background-color: yellow;">
	                        <?php echo number_format($sum); ?>
	                    </td>
	                </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>