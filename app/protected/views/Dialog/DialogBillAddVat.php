<?php
include_once '../MPDF57/mpdf.php';

$nowThai = Util::nowThai();

// style
$style = "
	<style>
		.text {
			font-size: 9px;
		}
		.bold {
			font-weight: bold;
		}
		.red {
			font-color: #FF0000;
		}
		.cell {
			padding: 5px;
			font-size: 9px;
			border-bottom: #cccccc 1px solid;
		}
		.cell-header {
			text-align: center;
			background: #cccccc;
		}
		.right {
			text-align: right;
		}
		.center {
			text-align: center;
		}
		.cell-footer {
			font-size: 9px;
		}
	</style>
";

// header text
$header_text = "
<table width='100%'>
	<tr>
		<td colspan='2' class='center bold'>
			ใบกำกับภาษี
		</td>
	</tr>
	<tr>
		<td colspan='2' class='text'>
			เลขที่: <span class='bolc'>{$billSale->bill_sale_id}</span>
			วันที่: <span class='bold red'>{$nowThai}</span>
		</td>
	</tr>
	<tr>
		<td class='text'>
			ร้าน: 
			<span class='bold red'>{$org->org_name}</span>
		</td>
		<td class='text'>
			สาขา:
			<span class='bold red'>{$billSale->branch->branch_name}</span>
		</td>
	</tr>
	<tr>
		<td colspan='2' class='text'>
			<div>{$org->org_address_1}</div>
			<div>{$org->org_address_2}</div>
			<div>{$org->org_address_3}</div>
			<div>{$org->org_address_4}</div>
			<div>
				<span style='padding-right: 40px'>
					เลขประจำตัวผู้เสียภาษี: {$org->org_tax_code}
				</span>
				
				<span style='padding-right: 40px'>
					โทรศัพท์: {$org->org_tel}				
				</span>
				
				แฟกซ์: {$org->org_fax}
			</div>	
		</td>
	</tr>
	<tr>
		<td colspan='2' class='text'>
			<div class='bold red'>ลูกค้า</div>
			<div>
				{$billSale->member->member_code} 
				{$billSale->member->member_name}
			</div>
			<div>{$billSale->member->member_tel}</div>
			<div>{$billSale->member->member_address}</div>
		</td>
	</tr>
</table>
";

// body
$body_text = "
	<table width='100%'>
		<thead>
			<tr>
				<td class='cell cell-header' width='40px'>ลำดับ</td>
				<td class='cell cell-header' width='100px'>รหัสสินค้า</td>
				<td class='cell cell-header'>ชื่อ</td>
				<td class='cell cell-header' width='50px'>จำนวน</td>
				<td class='cell cell-header' width='70px'>ราคาต่อหน่วย</td>
				<td class='cell cell-header' width='70px'>ราคารวม</td>
			</tr>
		</thead>
";

$n = 1;
$sumPrice = 0;

$criteria = new CDbCriteria();
$criteria->compare('bill_id', $billSale->bill_sale_id);

$billSaleDetails = BillSaleDetail::model()->findAll($criteria);

foreach ($billSaleDetails as $billSaleDetail) {
	$qty = $billSaleDetail->bill_sale_detail_qty;
	$price = $billSaleDetail->bill_sale_detail_price;
	$totalPricePerRow = ($qty * $price);
	
	$sumPrice += $totalPricePerRow;
	
	$body_text .= "
		<tr>
			<td class='cell right'>{$n}</td>
			<td class='cell center'>{$billSaleDetail->bill_sale_detail_barcode}</td>
			<td class='cell'>{$billSaleDetail->product->product_name}</td>
			<td class='cell right'>{$qty}</td>
			<td class='cell right'>{$price}</td>
			<td class='cell right'>{$totalPricePerRow}</td>
		</tr>
	";
	$n++;
}
$body_text .= "</table>";

// Footer
$vat = 0.00;

if ($billSale->bill_sale_vat == 'vat') {
	$vat = (0.07 * $sumPrice);
}

$vatText = number_format($vat);
$sumPriceText = number_format($sumPrice);
$beforeSumPrice = number_format($sumPrice - $vat);

$footer_text = "
<br />
<table width='100%'>
	<tr>
		<td class='cell-footer right'>รวมเป็นเงิน</td>
		<td class='cell-footer right' width='40px'>{$sumPriceText}</td>
	</tr>
	<tr>
		<td class='cell-footer right'>ยอดก่อนคิด In Vat</td>
		<td class='cell-footer right'>{$beforeSumPrice}</td>
	</tr>
	<tr>
		<td class='cell-footer right'>ภาษีมูลค่าเพิ่ม (In Vat) 7%</td>
		<td class='cell-footer right'>{$vatText}</td>
	</tr>
	<tr>
		<td class='cell-footer red right'>ยอดสุทธิ</td>
		<td class='cell-footer right'>
			<font style='border-bottom: 3px double #000000'>{$sumPriceText}</font>
		</td>
	</tr>
</table>
";

// HTML
$html = "
	$style
	$header_text
	$body_text
	$footer_text
";

// MPDF Render
$mpdf = new mPDF('UTF-8', 'A4', 0, 0, 5, 5, 5, 5);
$mpdf->SetAutoFont();
$mpdf->WriteHTML($html);
$mpdf->Output();

?>


