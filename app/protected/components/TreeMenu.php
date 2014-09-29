<?php
class TreeMenu
{
 
  public function getTreeData($dimCode)
  {
          $crt1=new CDbCriteria();
          $crt1->distinct=true;
          $crt1->select="group_code,DESCRIPTION";
          $crt1->condition="LEVEL=1 AND parent_code LIKE :parent_code";
          $crt1->params=array(':parent_code'=>$dimCode."%");
          $Ms1=Itemgroup::model()->findAll($crt1);
        
          $data1=array();
          foreach($Ms1 as $m1)
          {
            $crt2=new CDbCriteria();
            $crt2->distinct=true;
            $crt2->select="group_code,DESCRIPTION";
            $crt2->condition="LEVEL=2 AND parent_code=:parent_code";
            $crt2->params=array(':parent_code'=>$m1->group_code);
            $Ms2=Itemgroup::model()->findAll($crt2);
            if(count($Ms2)>0)
            {
                $data2=array();
                foreach($Ms2 as $m2)
                {
                  $crt3=new CDbCriteria();
                  $crt3->distinct=true;
                  $crt3->select="group_code,DESCRIPTION";
                  $crt3->condition="LEVEL=3 AND parent_code=:parent_code";
                  $crt3->params=array(':parent_code'=>$m2->group_code);
                  $Ms3=Itemgroup::model()->findAll($crt3);
                  if(count($Ms3))
                  {   
                      $data3=array();
                      foreach($Ms3 as $m3)
                      {
                            //$crt4=new CDbCriteria();
                            //$crt4->distinct=true;
                            //$crt4->select="group_code,DESCRIPTION";
                            //$crt4->condition="LEVEL=4 AND parent_code=:parent_code";
                            //$crt4->params=array(':parent_code'=>$m3->group_code);
                            //$Ms4=Itemgroup::model()->findAll($crt3);
                            //if(count($Ms4)>0)
                            //{
                             //   $data4=array();
                             //   foreach($Ms4 as $m4)
                             //   {
                             //     $data4[]=array('group_code'=>$m4->group_code,'description'=>$m4->DESCRIPTION,'level'=>4);
                             //   }
                             //   $data3[]=array('group_code'=>$m3->group_code,'description'=>$m3->DESCRIPTION,'dataGroup'=>$data4,'level'=>3);
                            //}
                            //else
                            //{
                              $data3[]=array('group_code'=>$m3->group_code,'description'=>$m3->DESCRIPTION,'level'=>3);
                            //}
                      }
                      $data2[]=array('group_code'=>$m2->group_code,'description'=>$m2->DESCRIPTION,'dataGroup'=>$data3,'level'=>2);

                  }
                  else
                  $data2[]=array('group_code'=>$m2->group_code,'description'=>$m2->DESCRIPTION,'level'=>2);
                }
                $data1[]=array('group_code'=>$m1->group_code,'description'=>$m1->DESCRIPTION,'level'=>1,'dataGroup'=>$data2);

            }
            else
            $data1[]=array('group_code'=>$m1->group_code,'description'=>$m1->DESCRIPTION,'level'=>1);

          }  
          $this->layout='empty';
        return $data1;  
  }
}

?>

 

