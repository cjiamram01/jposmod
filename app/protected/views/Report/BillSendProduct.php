<?php
include_once '../MPDF57/mpdf.php';

$billSaleId = Yii::app()->session['last_bill_sale_id'];
$date_time = date('d/m/Y h:i');

// header
$td_logo = '';

if ($org->org_logo_show_on_bill == 'yes') {
	$td_logo = "
		<td width='80px'>
			<img src='upload/{$org->org_logo}' width='60px' />
		</td>
	";
}
$header = "
	<table width='100%'>
		<tr valign='top'>
			{$td_logo}
			<td align='center'>
				<div class='header-text bold'>
					ใบส่งสินค้า
				</div>
			    <div class='header-text'>
			    	{$org->org_name} {$org->org_name_eng}
			    </div>
			    <div class='header-text'>
			    	เลขประจำตัวผู้เสียภาษี: {$org->org_tax_code} เบอร์โทร; {$org->org_tel}
			    </div>
			    <div class='header-text'>
			    	{$org->org_address_1} {$org->org_address_2}
			    </div>
			    <div class='header-text'>
			    	{$org->org_address_3} {$org->org_address_4}
			    </div>
			    <div class='header-text'>
			    	วันที่: $date_time เลขที่บิล: $billSaleId
			    </div>
			</td>
		</tr>
	</table>	
    ";
    
// to member
$header .= "
    <div class='row'>
        <span>ลูกค้า: {$member->member_name}</span>
        <span>&nbsp;&nbsp;&nbsp;</span>
        <span>เบอร์โทร: {$member->member_tel}</span>
    </div>
    <div class='row'>ที่อยู่: {$member->member_address}</div>
    <br />";

// content
$content = "
    <table width='100%' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <td class='cell-header' style='text-align: center'>ลำดับ</td>
                <td class='cell-header'>รหัสสินค้า</td>
                <td class='cell-header'>รายการ</td>
                <td class='cell-header' style='text-align: right'>ราคา</td>
                <td class='cell-header' style='text-align: right'>จำนวน</td>
                <td class='cell-header' style='text-align: right'>รวม</td>
            </tr>
        </thead>
        <tbody>";

$sum = 0;
$sum_qty = 0;
$i = 1;

// table body
foreach ($billSaleDetail as $r) {
    $product_code = $r->bill_sale_detail_barcode;
    $product_name = $r->product->product_name;
    $product_price = $r->bill_sale_detail_price;
    $product_qty = $r->bill_sale_detail_qty;
   
    $price_per_row = ($product_qty * $product_price);
    
    $sum += $price_per_row;
    $sum_qty += $product_qty;
    
    $price_per_row = number_format($price_per_row);
    $product_price = number_format($product_price);
    $product_qty = number_format($product_qty);
    
    $content .= "
        <tr>
            <td class='cell' style='text-align: center'>$i</td>
            <td class='cell'>$product_code</td>
            <td class='cell'>$product_name</td>
            <td class='cell' style='text-align: right'>$product_price</td>
            <td class='cell' style='text-align: right'>$product_qty</td>
            <td class='cell' style='text-align: right'>$price_per_row</td>
        </tr>";
    $i++;
}

// table footer
$sum_qty = number_format($sum_qty);
$sum_price = number_format($sum);
$content .= "
        </tbody>
        <tfoot>
            <tr>
                <td class='text bold'>รวม</td>
                <td></td>
                <td></td>
                <td></td>
                <td class='cell-footer'>$sum_qty</td>
                <td class='cell-footer'>$sum_price</td>
            </tr>
        </tfoot>
    </table>
    <br />";

// footer
$footer = "
    <table width='100%'>
        <tr>
            <td class='text' style='text-align: center; font-weight: bold'>ผู้ส่งสินค้า</td>
            <td class='text' style='text-align: center; font-weight: bold'>พนักงานขาย</td>
            <td class='text' style='text-align: center; font-weight: bold'>ผู้รับสินค้า</td>
        </tr>
        <tr>
            <td align='center'>
                <span class='blank-row'>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
            </td>
            <td align='center'>
                <span class='blank-row'>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
            </td>
            <td align='center'>
                <span class='blank-row'>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
            </td>
        </tr>
    </table>
    <br />";

$html = $header.$content.$footer;
$mpdf = new mPDF('UTF-8', 'A6-L', 0, 0, 5, 5, 5, 5);
$mpdf->SetAutoFont();
$mpdf->WriteHTML(file_get_contents('css/report.css'), 1);
$mpdf->WriteHTML($html);
$mpdf->Output();
?>

