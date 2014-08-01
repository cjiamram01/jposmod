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
    <div class="panel-heading">รายงานยอดขายตามเดือน</div>
    <div class="panel-body">
        <?php echo CHtml::form(Yii::app()->controller->createUrl('//Report/SaleSumPerMonth'), 'post', array('name' => 'form1')); ?>
        <div>
            <label>เลือกปี</label>
            <?php
            if ($_POST) {
                echo CHtml::dropDownList("year_find", $_POST['year_find'], Util::yearRange(), array(
                		'style' => 'width: 200px',
                		'class' => 'form-control'
                	));
            } else {
                echo CHtml::dropDownList("year_find", date('Y'), Util::yearRange(), array(
                		'style' => 'width: 200px',
                		'class' => 'form-control'
                	));
            }
            ?>
  
            <a href="#" class="btn btn-primary" onclick="document.form1.submit();">
                <i class="glyphicon glyphicon-ok"></i>
                แสดงรายงาน
            </a>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
    <br />

    <!-- report show -->
    <?php if ($_POST) : ?>
        <?php
        if (count($result) != 0) {
            foreach ($result as $value) {
                $resultArray[] = '[Date.UTC(' . $year . ', ' . ($value['month'] - 1) . '), ' . $value['MONEY'] . ']';
            }

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
                        text: 'ข้อมูลยอดขายตามเดือน ปี : <?php echo Util::YearThai($year); ?>',
                        align: 'center',
                        style: {
                            color: 'red',
                            fontWeight: 'bold'
                        }
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%b'
                        }
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
                        bar: {
                            colorByPoint: true
                        }
                    },
                    series: [{
                            type: 'bar',
                            name: 'บาท',
                            data: <?php echo $series_obj; ?>
                        }]
                }); // end highchart.js
                        
            });
        </script>

        <div class="panel_body">
            <div id="container" style="height: 400px; width: 91.6%; margin: auto; margin-top: -25px"></div>

            <div style="border: #aaa solid 1px; margin: 5px 0 25px 0;"></div>

            <table border="1" width="40%" style="margin: auto; margin-top: 10px;">
                <tr style="background-color: #eee;">
                    <td colspan="3" style="text-align: center; padding: 15px;">
                        <span style="font-size: 20px; color: #555;">รายงานยอดขายตามเดือนใน ปี : 
                            <span style="font-size: 20px; color: red;"><?php echo Util::YearThai($year); ?></span></span>
                    </td>
                </tr>
                <tr>
                    <th width="5%">NO</th>
                    <th width="25%">วันที่</th>
                    <th width="10%">จำนวนเงิน</th>
                </tr>
                <?php
                $i = 1;
                if ($result != "") {
                    foreach ($result as $value) :
                        ?>
                        <tr style="background-color: #fafafa;">
                            <td style="text-align: center;"><?php echo $i++; ?></td>
                            <td style="padding-left: 10%;">
                                <?php echo Util::MonthYearThai($value['bill_sale_created_date']); ?>
                            </td>
                            <td style="text-align: right; padding-right: 1%;">
                                <?php echo number_format($value['MONEY'], 2); ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                } // endif  
                ?>
                <tr>
                    <td colspan="2" style="text-align: right; padding-right: 10px; background-color: #ddd;">
                        <span style="font-weight: bold; font-size: 13px;">สรุปยอดเงินทั้งหมด : </span>
                    </td>
                    <td style="text-align: right; padding-right: 1%; background-color: yellow;">
                        <?php
                        if ($result_sum != "") {
                            foreach ($result_sum as $sum) {
                                echo number_format($sum['SUM_MONEY'], 2);
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

</div>