<?php $strPath= Yii::app()->baseUrl; ?>
<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">ข้อมูลผู้ใช้งานระบบ</div>
    <div class="panel-body">
			<a href="<?php echo $strPath; ?>/Config/UserForm" class="btn btn-primary">
				<b class="glyphicon glyphicon-plus"></b>
				เพิ่มรายการ
			</a>
			
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
            'columns' => array(
                'user_name',
                'user_tel',
                'user_level',
                'user_username',
                'user_created_date',
								'Branch.branch_name',
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit} {del}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => '
															<span class="btn btn-success">
																<b class="glyphicon glyphicon-align-justify"></b>
																แก้ไข
															</span>',
                            'url' => 'Yii::app()->createUrl("Config/UserForm", array(
															"id" => $data->user_id
														))'
                        ),
                        'del' => array(
                            'label' => '
																<span class="btn btn-danger">
																	<b class="glyphicon glyphicon-trash"></b>
																	ลบ
																</span>
														',
                            'url' => 'Yii::app()->createUrl("Config/UserDelete", array(
															"id" => $data->user_id
														))',
                            'options' => array(
                                'onclick' => 'return confirm("ยืนยันการลบ")'
                            )
                        )
                    ),
                    'htmlOptions' => array(
                        'width' => '150px',
                        'align' => 'center'
                    )
                )
            )
        ));
        ?>
    </div>
</div>