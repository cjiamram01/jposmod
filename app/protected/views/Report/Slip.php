<?php
include_once '../MPDF57/mpdf.php';
$billSaleId = Yii::app()->session['last_bill_sale_id'];

// header bill
$td_logo = '';

if ($org->org_logo_show_on_bill == 'yes') {
	$td_logo = "
		<td>
			<img src='upload/{$org->org_logo}' width='45px' />
		</td>
	";	
}

$html = "
	<table width='100%'>
		<tr>
			$td_logo
			<td>
				<div style='font-size: 10px; text-align: center;'>
					{$org->org_name}
				</div>
				<div style='font-size: 10px; text-align: center;'>
					<div>TAX: {$org->org_tax_code}</div>
					<div>โทร.{$org->org_tel}</div>
				</div>
				<div style='font-size: 10px; text-align: center;'>
					Bill NO: {$billSaleId}
				</div>
			</td>
		</tr>
	</table>
	<br />
    ";

// body bill
$sum = 0;
$sum_qty = 0;

foreach ($billSaleDetail as $r) {
    $product_code = $r->bill_sale_detail_barcode;
    $product_name = $r->product->product_name;
    $product_price = $r->bill_sale_detail_price;
    $product_qty = $r->bill_sale_detail_qty;
   
    $price_per_row = ($product_qty * $product_price);
    
    $sum += $price_per_row;
    $sum_qty += $product_qty;
    
    $html .= "
    	<div style='font-size: 9px; padding-top: 1px; padding-bottom: 1px;'> 
    		{$product_name} {$product_qty} x {$product_price} = {$price_per_row}
    	</div>";

    $n++;
}
$html .= "<br />";

// footer
$vat = number_format(($sum * .07), 2);
$sum = number_format($sum, 2);
$input = number_format(Yii::app()->session['input'], 2);
$change = number_format(Yii::app()->session['returnMoney'], 2);
$date_time = date('d/m/Y h:i');

$html .= "
    <div style='font-size: 9px;'>ทั้งหมด: ($sum_qty) $sum ";
    
if ($billSale->bill_sale_vat == 'vat') {
	$html .= "&nbsp;&nbsp; VAT: $vat";
}

$html .= "
	</div>
    <div style='font-size: 9px;'>รับเงิน: $input</div>
    <div style='font-size: 9px;'>เงินทอน: $change</div>
    <br />
    <div style='font-size: 9px'>$date_time</div>";

$mpdf = new mPDF('UTF-8', array(70, 100), 0, 0, 5, 5, 5, 5);
$mpdf->SetAutoFont();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>

