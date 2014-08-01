<?php 
if (empty($result)) {
	echo "<div><strong>ไม่มีข้อมูลในการแสดงรายงาน</strong></div>";
} else {
	include_once '../MPDF57/mpdf.php';
	
	// condition
	if ($sale_condition_cash == 'cash') {
		$sale_condition_cash = 'เงินสด';
	}
	if ($sale_condition_credit == 'credit') {
		$sale_condition_credit = ' เงินเชื่อ';
	}
	
	if ($has_bonus_yes == 'yes') {
		$has_bonus_yes = 'มีส่วนลด';
	}
	if ($has_bonus_no == 'no') {
		$has_bonus_no = ' ไม่มีส่วนลด';
	}
	
	$branch_name = $branch->branch_name;
	
	// html text
	$html = "
		<style>
			* {
				font-size: 10px;
			}
			.cell-header {
				text-align: center;
				font-weight: bold;
				border-bottom: #808080 3px double;
			}
			.cell {
				padding: 5px;
				border-bottom: #cccccc 1px solid;
			}
			.footer {
				border-bottom: #cccccc 3px double;
				padding: 5px;
			}
		</style>
	
		<div>รายงานยอดขายประจำวัน : {$date_find}</div>
		<div>สาขา: {$branch_name}</div>
		<div>เงื่อนไขการขาย: {$sale_condition_cash} {$sale_condition_credit}</div>
		<div>เงื่อนไขส่วนลด: {$has_bonus_yes} {$has_bonus_no}</div>
		<br />
	
		<table border='1px'>
			<thead>
				<tr>
					<th width='50px' class='cell-header'>ลำดับ</th>
					<th width='80px' class='cell-header'>เลขที่บิล</th>
					<th width='100px' class='cell-header'>รหัสสินค้า</th>
					<th width='400px' class='cell-header'>รายการสินค้า</th>
					<th width='50px' class='cell-header'>จำนวน</th>
					<th width='130px' class='cell-header'>ราคาจำหน่าย/หน่วย</th>
					<th width='100px' class='cell-header'>จำหน่ายจริง</th>
					<th width='50px' class='cell-header'>ส่วนลด</th>
					<th width='80px' class='cell-header'>สถานะบิล</th>
					<th width='100px' class='cell-header'>จำนวนเงิน</th>
				</tr>
			</thead>

			<tbody>
	";
	
	$html .= "
		</tbody>
	";
	
	$sum = 0;
	
	// Data
	foreach ($result as $row) {
		$bill_sale_detail_qty = number_format($row['bill_sale_detail_qty']);
		$product_price = number_format($row['product_price']);
		$bill_sale_detail_price = number_format($row['bill_sale_detail_price']);
		
		$change = ($row['product_price'] - $row['bill_sale_detail_price']);
		$change_text = "&nbsp;";
                        	
        if ($change != 0) {
	        $change_text = number_format($change);
        }
		
		$bill_sale_status = $value['bill_sale_status'];
		$price_per_row = ($row['bill_sale_detail_price'] * $row['bill_sale_detail_qty']);
		$price_per_row_text = number_format($price_per_row);
		
		$sum += $price_per_row;
		
		
		$html .= "
			<tr>
				<td class='cell'>{$n}</td>
				<td class='cell'>{$row['bill_sale_id']}</td>
				<td class='cell' style='text-align: center'>
                	{$row['bill_sale_detail_barcode']}
                </td>
                <td class='cell'>
                    {$row['product_name']}
                </td>
                <td class='cell' style='text-align: right'>
                	{$bill_sale_detail_qty}
                </td>
                <td class='cell' style='text-align: right'>
                	{$product_price}
                </td>
                <td class='cell' style='text-align: right'>
                	{$bill_sale_detail_price}
                </td>
                <td class='cell' style='text-align: right'>
                    {$change_text}
                </td>
                <td class='cell' style='text-align: center;'>
                    {$bill_sale_status}
                </td>
                <td class='cell' style='text-align: right;'>
                	{$price_per_row_text}
                </td>
			</tr>";
			
		$n++;
	}
	
	$html .= "
		<tfoot>
			<tr>
				<td colspan='9'>รวม</td>
				<td class='footer' style='text-align: right'>{$sum}</td>
			</tr>	
		</tfoot>
	</table>
	";
	
	// Generate PDF
	$mpdf = new mPDF('UTF-8', 'A4-L', 0, 0, 5, 5, 5, 5);
	$mpdf->SetAutoFont();
	$mpdf->WriteHTML($html);
	$mpdf->Output();
}
?>
