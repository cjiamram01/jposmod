<?php $strPath= Yii::app()->baseUrl; ?>
<script type="text/javascript">
function generateDataList(groupLevel,groupCode)
{
  var URL = '<?php echo $strPath; ?>/Partial/ProductList?groupLevel='+groupLevel+"&groupCode="+groupCode;
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
    document.getElementById('divList').innerHTML = "Loading...";
    //"Loading...";
  }
} 
</script>
<div id="content" class="general-style1">
<?php 
function createTreeMenu($array)
 {
    echo "<ol class='tree'>";
    
    foreach($array as $m)
    {
      echo "<li>";
      if(isset($m["dataGroup"]))
      {
         echo "<label for='subfolder2' class='treelabel' onclick='generateDataList(".$m["level"].",".$m["group_code"].")' >".$m["description"]."</label> <input type='checkbox' id='subfolder2' />"; 
         createTreeMenu($m["dataGroup"]);
      }
      else
        //echo "<a href='#' class='treelabel' onclick=''>".$m["description"]."</a>"; 
        echo "<a href='#' class='treelabel' onclick='generateDataList(".$m["level"].",".$m["group_code"].")'>".$m["description"]."</a>"; 
      echo "</li>"; 
    }
      
    echo "</ol>";
  }
  echo createTreeMenu($categoriesData);
 ?>
</div>
