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

<script type="text/javascript">
    $(function() {
        $("input[name=date_start]").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '2010:2015'
        });
        
        $("input[name=date_end]").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '2010:2015'
        });
    });
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">รายงานยอดขายตามสมาชิก</div>
    <div class="panel-body">
        <?php echo CHtml::form(Yii::app()->controller->createUrl('//Report/SaleSumPerMember'), 'post', array('name' => 'form1')); ?>
        <div>
            <label>เลือกวันที่</label>
            <input type="text" name="date_start" class="form-control" style="width: 200px" value="<?php if ($_POST){ echo $_POST['date_start']; } ?>" />
            <label style="width: 100px">ถึง</label>
            <input type="text" name="date_end" class="form-control" style="width: 200px" value="<?php if ($_POST){ echo $_POST['date_end']; } ?>" />
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

    <div class="panel_body">

        <?php if ($_POST) : ?>

            <?php
            if (count($result) != 0) {

                // loop member_name            
                foreach ($result as $valName) {
                    $resultName[] = $valName['member_name'];
                }

                $data_nameObj = json_encode($resultName);

                // array value
                foreach ($result as $value) {
                    $arr_value[$value['member_id']] = $value['MONEY'];
                }

                foreach ($result as $value) {
                    $arr_main[$value['member_id']] = 0;
                }

                // array to highchart
                $data_series = $arr_value + $arr_main;

                foreach ($data_series as $value) {
                    $resultArray[] = $value;
                }

                // finish array to javascript (keep out string)
                $series_obj = str_replace(array('"'), "", json_encode($resultArray));
                
            } else {
                $data_nameObj = NULL;
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
                            categories: <?php echo $data_nameObj; ?>
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

                <table border="1" width="600px" style="margin: auto; margin-top: 10px;">
                    <tr style="background-color: #eee;">
                        <td colspan="3" style="text-align: center; padding: 15px;">
                            <span style="font-size: 18px; color: #555;">สรุปยอดขายตามสมาชิก ตั้งแต่วันที่ : 
                                <span style="font-size: 18px; color: red;"><?php echo $date; ?></span></span>
                        </td>
                    </tr>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="25%">สมาชิก</th>
                        <th width="10%">จำนวนเงิน</th>
                    </tr>
											<?php $i = 1; ?>
											<?php foreach ($result as $value): ?>
                        <tr style="background-color: #fafafa;">
                            <td style="text-align: center;"><?php echo $i++; ?></td>
                            <td style="text-align: left;">
															<?php echo $value['member_name']; ?>
                            </td>
                            <td style="text-align: right; padding-right: 1%;">
															<?php echo number_format($value['MONEY'], 2); ?>
                            </td>
                        </tr>
                        <?php $sum += $value['MONEY']; ?>
												<?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="padding-right: 10px; background-color: #ddd;">
                            <span style="font-weight: bold; font-size: 13px;">สรุปยอดเงินทั้งหมด : </span>
                        </td>
                        <td style="text-align: right; background-color: yellow;">
                            <?php echo number_format($sum, 2); ?>
                        </td>
                    </tr>
                </table>
            </div>
						<?php endif; ?>
    </div>
</div>