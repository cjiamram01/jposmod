<script type="text/javascript">
    $(function() {
       $("#inputMoney").focus(); 
    });
    
    function endSale() {
        var total = $("#totalMoney").val();
        var input = $("#inputMoney").val();
        var returnMoney = $("#returnMoney").val();
        
        // convert to number
        total = Number(total.replace(",", ""));
        input = Number(input.replace(",", ""));
        
        if (input < total) {
            alert("โปรดกรอกจำนวนเงินให้ถูกต้อง");
            return false;
        }
        
        $.ajax({
            url: 'index.php?r=Basic/EndSaleTempData',
            type: 'post',
            data: 
            {
                total: total,
                input: input,
                returnMoney: returnMoney
            },
            success: function(data) 
            {
                window.returnValue = true;
                window.close();
            }
        });
    }
    
    function processReturnMoney(e) {
        var total = $("#totalMoney").val();
        var input = $("#inputMoney").val();
        
        total = total.replace(",", "");
        var returnMoney = Number(input) - Number(total);
        
        $("#returnMoney").val(returnMoney);
        
        if (e.keyCode == 13) {
	        endSale();
        }
    }
</script>

<style>
	.return-money {
		font-size: 30px; 
		text-align: right; 
		display: inline-block; 
		padding-top: 10px;
		padding-bottom: 10px;
		height: 50px;
		width: 300px;
	}
	
	.total-money {
		font-size: 20px; 
		text-align: right; 
		padding-top: 10px;
		padding-bottom: 10px;
		height: 50px;
		width: 300px;
		display: inline-block;
		font-weight: bold;
		color: black;
	}
	
	.input-money {
		font-size: 30px; 
		text-align: right; 
		padding-top: 10px;
		padding-bottom: 10px;
		height: 50px;
		width: 300px;
		display: inline-block;
	}
	
	.end-sale {
		width: 710px; 
		font-size: 35px; 
		padding: 20px;
	}
	
	.lbl-total {
		font-size: 40px; 
		width: 200px
	}
	
	.lbl-input {
		font-size: 40px; 
		width: 200px
	}
	
	.lbl-return {
		font-size: 40px; 
		width: 200px
	}
	
	form div {
		margin-top: 1px;
		margin-bottom: 1px;
	}
	form div label {
		text-align: right;
		padding-right: 5px;
		width: 200px;
	}
</style>

<div class="panel panel-primary">
    <div class="panel-heading">จบการขาย</div>
    <div class="panel-body alert-info">
        <form class="form-inline">
            <div>
                <label class="lbl-total">จำนวนเงิน</label>
                <input 
	                type="text" 
	                id="totalMoney" 
	                readonly="readonly" 
	                value="<?php echo number_format($total); ?>" 
	                class="form-control total-money" />
            </div>
            <div>
                <label class="lbl-input">รับเงิน</label>
                <input 
                	type="text" 
                	id="inputMoney" 
                	onkeyup="processReturnMoney(event)" 
                	class="input-money form-control" />
            </div>
            <div>
                <label class="lbl-return">เงินทอน</label>
                <input 
                	type="text" 
                	id="returnMoney" 
                	disabled="disabled" 
                	class="return-money disabled form-control" />
            </div>
            <br />
            <div>
								<label></label>
                <a href="#" onclick="return endSale()" class="btn btn-success"
									style="font-size: 30px">
									<b class="glyphicon glyphicon-ok-circle"></b>
                    จบการขาย
                </a>
            </div>
        </form>
    </div>
</div>

