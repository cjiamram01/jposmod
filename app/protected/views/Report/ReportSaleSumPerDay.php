<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/js/highcharts.js" ?>"></script>

<style type="text/css">
    body {
        overflow-y: scroll;
    }
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

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">รายงานยอดขายวัน</div>
    <div class="panel-body">
        <?php echo CHtml::form(Yii::app()->controller->createUrl('//Report/SaleSumPerDay'), 'post', array('name' => 'form1')); ?>

        <div>
            <label>เลือกเดือน</label>
            <?php echo CHtml::dropDownList("month", $month, Util::monthRange(), array(
            		'class' => 'form-control',
            		'style' => 'width: 200px'
            )); ?>
            <label>เลือกปี</label>
            <?php echo CHtml::dropDownList("year", $year, Util::yearRange(), array(
            		'class' => 'form-control',
            		'style' => 'width: 200px'
            )); ?>
        </div>
        <div>
            <label></label>
            <a href="#" class="btn btn-primary" onclick="document.form1.submit();">
                <i class="glyphicon glyphicon-ok"></i>
                แสดงรายงาน
            </a>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
    <br />

    <?php if ($_POST) : ?>

        <?php
        if (count($result) != 0) {

            // cal day per month
            $dayInMonth = cal_days_in_month(CAL_JULIAN, $month, $year);

            // loop money per days
            foreach ($result as $val) {
                $moneyPerDays[(int) substr($val['bill_sale_created_date'], 8, 2)] = $val['MONEY'];
            }

            // loop date
            for ($i = 1; $i <= $dayInMonth; $i++) {
                $dateData[$i] = "0";
            }

            // sum array
            $sumArray = $moneyPerDays + $dateData;
            ksort($sumArray);

            // sort array
            foreach ($sumArray as $key => $value) {

                // array for highchart.js
                $resultArray[] = '[Date.UTC(' . $year . ', ' . ($month - 1) . ', ' . $key . '),' . $value . ']';
            }

            // finish array to javascript (keep out string)
            $series_obj = str_replace(array('"'), "", json_encode($resultArray));
        } else {
            $series_obj = NULL;
        }
        ?>

        <script type="text/javascript">
            $(function () {
                            
                var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container'
                    },
                    title: {
                        text: 'ข้อมูลยอดขายตามวัน เดือน : <?php echo $date; ?>',
                        align: 'center',
                        style: {
                            color: 'red',
                            fontWeight: 'bold'
                        }
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: [{
                            title: {
                                text: 'จำนวนเงิน (บาท)'
                            }
                        }],
                    credits: {
                        enabled: false
                    },
                                
                    tooltip: {
                        formatter: function() {
                            return 'จำนวนเงิน : '+ this.y +' บาท'
                        }
                    },
                    plotOptions: {
                        column: {
                            colorByPoint: true
                        }
                    },
                    series: [{
                            type: 'column',
                            name: 'บาท',
                            data: <?php echo $series_obj; ?>
                                    
                        }]
                }); // end highchart.js
                            
            });
        </script>

        <div class="panel_body">
            <div id="container" style="height: 400px; width: 91.6%; margin: auto; margin-top: -25px"></div>

            <div style="border: #aaa solid 1px; margin: 25px 0 25px 0;"></div>

            <table border="1" width="40%" style="margin: auto; margin-top: 10px;">
                <tr style="background-color: #eee;">
                    <td colspan="3" style="text-align: center; padding: 15px;">
                        <span style="font-size: 20px; color: #555;">รายงานยอดขายตามวัน เดือน : 
                            <span style="font-size: 20px; color: red;"><?php echo $date; ?></span></span>
                    </td>
                </tr>
                <tr>
                    <th width="5%">NO</th>
                    <th width="25%">วันที่</th>
                    <th width="10%">จำนวนเงิน</th>
                </tr>
                <?php
                $i = 1;
                foreach ($result as $value) :
                    ?>
                    <tr style="background-color: #fafafa;">
                        <td style="text-align: center;"><?php echo $i++; ?></td>
                        <td style="text-align: center;">
                            <?php echo Util::DateThai($value['bill_sale_created_date']); ?>
                        </td>
                        <td style="text-align: right; padding-right: 1%;">
                            <?php echo number_format($value['MONEY'], 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" style="text-align: left; padding-right: 10px; background-color: #ddd;">
                        <span style="font-weight: bold; font-size: 13px;">สรุปยอดเงินทั้งหมด : </span>
                    </td>
                    <td style="text-align: right; padding-right: 1%; background-color: yellow;">
                        <?php echo number_format($sum, 2); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

</div>