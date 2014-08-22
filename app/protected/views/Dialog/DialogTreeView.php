 
 <script type="text/javascript">
  $(function()
    {
    //Initialise JQUERY4U JSON Tree Viewer
      JSONTREEVIEWER.init();
      JSONTREEVIEWER.processJSONTree('ItemGroup7.json');
    }
  );
  </script>
 <input type="checkbox" id="hierarchy_chk" name="hierarchy_chk" title="" checked /> 
<input type="text" id="pathdelim_chk" value="." />
<div class="panel panel-primary">
  <div class="panel-heading">เลือกกลุ่มสินค้า</div>
  <div class="panel-body">
  	  <div class="col-sm-3" >
 
        <ul id="browser" class="filetree treeview-famfamfam">
        </ul>
  	  </div>
  	  <div class="col-sm-9">
  	  </div>
  </div>
  </div>
 </div> 
