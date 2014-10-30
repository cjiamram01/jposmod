<script type="text/javascript">
<?php $strPath= Yii::app()->baseUrl; ?>
function chooseData()
{
  var sel = document.getElementById('ddlSelectDim');
  var sv = sel.options[sel.selectedIndex].value;
  generateTree(sv);
}

function generateTree(dimCode)
{
  var URL = '<?php echo $strPath; ?>/Partial/GenerateTreeview?dimCode='+dimCode;

  if (window.XMLHttpRequest)
  {req=new XMLHttpRequest();}
  else if (window.ActiveXObject)
  {req=new ActiveXObject("Microsoft.XMLHTTP");}
  else
  {return false;}
  
  req.onreadystatechange = statechange;
  req.open("GET",URL,true);
  req.send(null);
}
      
function statechange()
{
  if (req.readyState==4)
  {
    document.getElementById("divTree").innerHTML=req.responseText;
  }
  else
  {
    document.getElementById('divTree').innerHTML = "<img src='<?php echo $strPath?>/images/loading.gif'>";
  }
} 

function generateDataList(groupLevel,groupCode)
{
  var URL = '<?php echo $strPath; ?>/Partial/ProductList?groupLevel='+groupLevel+"&groupCode="+groupCode;
  //var URL = '<?php echo $strPath; ?>/GR/listGR?groupLevel='+groupLevel+"&groupCode="+groupCode;
  
  //document.write(URL);
  if (window.XMLHttpRequest)
  {req=new XMLHttpRequest();}
  else if (window.ActiveXObject)
  {req=new ActiveXObject("Microsoft.XMLHTTP");}
  else
  {return false;}
  
  req.onreadystatechange = stateTreeChange;
  req.open("GET",URL,true);
  req.send(null);
}

function stateTreeChange()
{
  if (req.readyState==4)
  {
    document.getElementById("divList").innerHTML=req.responseText;
  }
  else
  {
    document.getElementById('divList').innerHTML = "<img src='<?php echo $strPath?>/images/loading.gif'>";
    //"Loading...";
  }
} 

//window.onload=generateTree('');


function PopupCenter(url, title, w, h) 
  {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'directories=0,titlebar=0,addressbar=0,scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
        if (window.focus) 
        {
            newWindow.focus();
        }
      return newWindow; 
   }

 function chooseGR(productCode) 
   {
      var uri = "<?php echo $strPath; ?>/Dialog/DialogGR?productCode="+productCode;
      PopupCenter(uri,"Browse GR.",800,400);
   }


</script>
<div class="col-sm-4">
<div class="panel panel-primary" style="margin: 10px">
 
  <div class="panel-heading">ระบบการปรับปรุงวัสดุ</div>
   <div class="panel-body">
     <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formTree',
            'id' => 'formTree'
        )
    ));
    ?>

      <table width="100%">
      <tr>
        <td width="300px" valign="top">
         <div class="row">
         <div class="col-sm-10">
              <?php 
                $crt=new CDbCriteria();
                $crt->select="code,dimension";
                $dimension=Dimension::model()->findAll($crt);
                $array = CHtml::listData($dimension, 'code', 'dimension');
                echo CHtml::dropDownList('ddlSelectDim', '', $array,array('class'=>'form-control','empty'=>'---Choose dimension---','onchange'=>'chooseData()'));               
              ?>  
         </div>
         </div>
          <div class="row">
            <div class="col-sm-12" id="divTree">
            </div>
          </div>
        </td>      
      </tr>
    </table>

     

        <?php $this->endWidget(); ?>

   </div>
</div>

</div>
 <div class="col-sm-8 ">
    <div class="panel panel-primary" id="divList"  style="margin: 10px">
    </div>
</div>

