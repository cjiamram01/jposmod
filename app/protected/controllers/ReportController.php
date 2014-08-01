<?php

class ReportController extends Controller {

    function actionSalePerDay() {
    		$params = array();
    	
			// checked
    		$checked_cash = 'checked="checked"';
			$checked_credit = 'checked="checked"';
    	
    		$checked_bonus_no = 'checked="checked"';
			$checked_bonus_yes = 'checked="checked"';
    	
    		$branch_id = null;
    	
        if (!empty($_POST)) {
        	// data
        	$sale_condition_cash = $_POST['sale_condition_cash'];
        	$sale_condition_credit = $_POST['sale_condition_credit'];
        	
        	$has_bonus_yes = $_POST['has_bonus_yes'];
        	$has_bonus_no = $_POST['has_bonus_no'];
        	
        	$branch_id = $_POST['branch_id'];
        	
        	// checked
        	if (!empty($sale_condition_cash)) {
	        	$checked_cash = 'checked="checked"';
        	} else {
	        	$checked_cash = '';
        	}
        	
        	if (!empty($sale_condition_credit)) {
	        	$checked_credit = 'checked="checked"';
        	} else {
	        	$checked_credit = '';
        	}
        	
        	if (!empty($has_bonus_yes)) {
	        	$checked_bonus_yes = 'checked="checked"';
        	} else {
	        	$checked_bonus_yes = '';
        	}
        	
        	if (!empty($has_bonus_no)) {
	        	$checked_bonus_no = 'checked="checked"';
        	} else {
	        	$checked_bonus_no = '';
        	}
        	        	
        	// SQL Condition
	        if (!empty($sale_condition_cash)) {
		        $condition_sale = "AND bill_sale_status = 'pay'";
	        } 
	        if (!empty($sale_condition_credit)) {
	        	$condition_sale = "AND bill_sale_status = 'credit'";	        	
	        }
	        if (!empty($sale_condition_cash) && !empty($sale_condition_credit)) {
		        $condition_sale = "AND bill_sale_status IN('credit', 'pay')";
	        }
	        
	        if (!empty($has_bonus_no)) {
		        $condition_has_bonus = "AND bill_sale_detail_has_bonus = 'no'";
	        } 
	        if (!empty($has_bonus_yes)) {
	        	$condition_has_bonus = "AND bill_sale_detail_has_bonus = 'yes'";	        	
	        }
	        if (!empty($has_bonus_no) && !empty($has_bonus_yes)) {
		        $condition_has_bonus = "AND bill_sale_detail_has_bonus IS NOT NULL";
	        }
	        	
	        // Date
            $date_find = Util::thaiToMySQLDate($_REQUEST['date_find']);
            $date = explode('-', $date_find);
            $y = $date[0];
            $m = $date[1];
            $d = $date[2];
            
            // SQL Command
            $sql = "
            	SELECT * FROM tb_bill_sale_detail
            	LEFT JOIN tb_bill_sale ON tb_bill_sale.bill_sale_id = tb_bill_sale_detail.bill_id
            	LEFT JOIN tb_product ON tb_product.product_code = tb_bill_sale_detail.bill_sale_detail_barcode
            	WHERE
            		bill_sale_detail_barcode != ''
            		AND 
            		(
            			YEAR(tb_bill_sale.bill_sale_created_date) = $y
								AND MONTH(bill_sale_created_date) = $m 
								AND DAY(bill_sale_created_date) = $d 
							)
            		$condition_sale
            		$condition_has_bonus
            		AND tb_bill_sale.branch_id = $branch_id
            ";
                        
            // query all
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            $params['date'] = $date_find;
            $params['result'] = $result;
            
            // save result to session
            $session = new CHttpSession();
            $session->open();
            $session['result'] = $result;
            $session['date_find'] = $date_find;
            $session['sale_condition_cash'] = $sale_condition_cash;
            $session['sale_condition_credit'] = $sale_condition_credit;
            $session['has_bonus_no'] = $has_bonus_no;
            $session['has_bonus_yes'] = $has_bonus_yes;
            $session['branch_id'] = $branch_id;
        }
        
        $params['checked_cash'] = $checked_cash;
        $params['checked_credit'] = $checked_credit;
        $params['checked_bonus_yes'] = $checked_bonus_yes;
        $params['checked_bonus_no'] = $checked_bonus_no;
        $params['branch_id'] = $branch_id;
        
        $this->render('//Report/ReportSalePerDay', $params);
    }

    function actionSaleSumPerDay() {
        $month = date("m");
        $year = date("Y");
        
        if (!empty($_POST)) {
          $month = $_POST['month'];
          $year = $_POST['year'];

          $date = Util::MonthThai($month) . ' ' . Util::YearThai($year);

					$sql = "
						SELECT bill_sale_created_date, bill_sale_status, SUM(bill_sale_detail_price) AS MONEY
						FROM tb_bill_sale_detail AS a
						LEFT JOIN tb_bill_sale AS b ON a.bill_id = b.bill_sale_id
						LEFT JOIN tb_product AS c ON c.product_code = a.bill_sale_detail_barcode
						GROUP BY 
							date(bill_sale_created_date), bill_sale_status
						HAVING 
							month(bill_sale_created_date) = $month
							AND year(bill_sale_created_date) = $year
							AND bill_sale_status IN('pay', 'credit')
					";

          // query all
          $result = Yii::app()->db->createCommand($sql)->queryAll();

          // query sum
          $sum = 0;
            
          foreach ($result as $r) {
            $sum += $r['MONEY'];
          }

          $this->render('//Report/ReportSaleSumPerDay', array(
            "month" => $month,
            "year" => $year,
            "date" => $date,
            "result" => $result,
            "sum" => $sum,
          ));
        } else {
          $this->render('//Report/ReportSaleSumPerDay', array(
            'month' => $month,
            'year' => $year
          ));
        }
    }

    function actionSaleSumPerMonth() {
        if ($_POST) {
            $year = $_REQUEST['year_find'];
            
            $sql = "
            	SELECT 
            		bill_sale_created_date, 
            		month(bill_sale_created_date) as month, 
            		bill_sale_status, 
            		SUM(bill_sale_detail_price) AS MONEY
            	FROM
            		tb_bill_sale AS a
            	INNER JOIN tb_bill_sale_detail AS b
            		ON b.bill_id = a.bill_sale_id
            	INNER JOIN tb_product AS c
            		ON c.product_id = b.bill_sale_detail_barcode
            	GROUP BY
            		month(bill_sale_created_date), bill_sale_status
            	HAVING
            		year(bill_sale_created_date) = $year
            		AND bill_sale_status = 'pay'
            ";

            // query all
            $result = Yii::app()->db->createCommand($sql)->queryAll();

            // query sum
            $sql = "
            	SELECT 
            		count(b.bill_sale_detail_price) AS SUM_COUNT, 
            		SUM(b.bill_sale_detail_price) AS SUM_MONEY
            	FROM
            		tb_bill_sale AS a
            	INNER JOIN
            		tb_bill_sale_detail AS b
            		ON b.bill_id = a.bill_sale_id
            	INNER JOIN
            		tb_product AS c
            		ON c.product_id = b.bill_sale_detail_barcode
            	WHERE
            		year(bill_sale_created_date) = $year
					AND bill_sale_status = 'pay'
            ";
            $result_sum = Yii::app()->db->createCommand($sql)->queryAll();

            $this->render('//Report/ReportSaleSumPerMonth', array(
                "year" => $year,
                "result" => $result,
                "result_sum" => $result_sum,
            ));
        } else {
            $this->render('//Report/ReportSaleSumPerMonth');
        }
    }

    function actionSaleSumPerType() {
        if ($_POST) {
            $date_start = Util::thaiToMySQLDate($_REQUEST['date_start']);
            $date_end = Util::thaiToMySQLDate($_REQUEST['date_end']);

            $date = Util::DateThai($date_start) . ' ถึง ' . Util::DateThai($date_end);

            // query all
            $sql = "
            	SELECT
            		g.group_product_id,
                    g.group_product_name, 
                    (
                    	SELECT
                        	SUM(bill_sale_detail_price * bill_sale_detail_qty)
                        FROM tb_bill_sale_detail
                        LEFT JOIN tb_bill_sale 
                            ON tb_bill_sale.bill_sale_id = tb_bill_sale_detail.bill_id
                        LEFT JOIN tb_product 
                            ON tb_product.product_code = tb_bill_sale_detail.bill_sale_detail_barcode
                        WHERE tb_bill_sale.bill_sale_created_date BETWEEN '{$date_start}' AND '{$date_end}'
                        AND tb_product.group_product_id = g.group_product_id
                    ) AS money
                FROM
                	tb_group_product g
            ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();

            // query sum
            $result_sum = 0;
            foreach ($result as $r) {
                $result_sum += $r['money'];
            }

            $this->render('//Report/ReportSaleSumPerType', array(
                "date" => $date,
                "result" => $result,
                "result_sum" => $result_sum,
            ));
        } else {
            $this->render('//Report/ReportSaleSumPerType');
        }
    }

    function actionSaleSumPerMember() {
        if (!empty($_POST)) {
            $date_start = Util::thaiToMySQLDate($_REQUEST['date_start']);
            $date_end = Util::thaiToMySQLDate($_REQUEST['date_end']);

            $date = Util::DateThai($date_start) . ' ถึง ' . Util::DateThai($date_end);

            // query all
            $sql = "
	            	SELECT 
	            		d.member_id, 
	            		member_name, 
	            		SUM( bill_sale_detail_price ) AS MONEY,
	            		a.bill_sale_created_date,
	            		a.bill_sale_status
	            	FROM tb_bill_sale AS a
	            	INNER JOIN tb_bill_sale_detail AS b ON b.bill_id = a.bill_sale_id
	            	INNER JOIN tb_product AS c ON c.product_id = b.bill_sale_detail_barcode
	            	INNER JOIN tb_member AS d ON d.member_id = a.member_id
	            	GROUP BY d.member_id
	            	HAVING
	            		a.bill_sale_created_date between '$date_start' AND '$date_end'
	            		AND bill_sale_status = 'pay'
            ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();

            $this->render('//Report/ReportSaleSumPerMember', array(
                "date" => $date,
                "result" => $result,
                "sum" => 0,
            ));
        } else {
            $this->render('//Report/ReportSaleSumPerMember');
        }
    }

    function actionSaleSumPerEmployee() {
        if ($_POST) {
            $date_start = Util::thaiToMySQLDate($_REQUEST['date_start']);
            $date_end = Util::thaiToMySQLDate($_REQUEST['date_end']);

            $date = Util::DateThai($date_start) . ' ถึง ' . Util::DateThai($date_end);

            // query all
            $sql = "
            	SELECT 
            		d.user_id,
            		user_name, 
            		(
            			SELECT SUM(bill_sale_detail_price) FROM tb_bill_sale_detail
            			WHERE bill_id = a.bill_sale_id
            			AND a.bill_sale_created_date BETWEEN '$date_start' AND '$date_end'
            	  ) AS MONEY,
            		a.bill_sale_created_date,
            		a.bill_sale_status
            	FROM tb_bill_sale AS a
            	INNER JOIN tb_user AS d ON d.user_id = a.user_id
            	GROUP BY a.user_id
            	HAVING
            		(bill_sale_created_date between '$date_start' AND '$date_end')
            		AND
            		(bill_sale_status = 'pay')
            ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();

            $this->render('//Report/ReportSaleSumPerEmployee', array(
                "date" => $date,
                "result" => $result,
                "sum" => 0,
            ));
        } else {
            $this->render('//Report/ReportSaleSumPerEmployee');
        }
    }
    
    function actionProductStock() {
        $this->render('//Report/ReportProductStock');        
    }
    
    function actionReportAR() {
        if($_POST) {
            
            // query all
            $sql = "
            	SELECT * FROM tb_ar AS a
            	INNER JOIN
            		tb_member AS b
            		ON b.member_id = a.member_id
            	ORDER BY b.member_name ASC
            ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            $this->render('//Report/ReportAR', array(
                "result" => $result
            ));
        } else {
            $this->render('//Report/ReportAR');
        }
    }
    
    function actionReportIR() {
        if($_POST) {
            
            // query all
            $sql = "
            	SELECT * FROM tb_farmer AS a
            	ORDER BY a.farmer_id ASC
            ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            $this->render('//Report/ReportIR', array(
                "result" => $result,
            ));
        } else {
            $this->render('//Report/ReportIR');
        }
    }
    
}

?>
