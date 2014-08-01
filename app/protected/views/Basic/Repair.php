<script type="text/javascript">
    function startRepair() {
        var url = "<?php echo Yii::app()->createUrl("Basic/startRepair", array('serial_code' => @$search_code)); ?>";
        window.location = url;
    }
    
    function browseSerial() {
        var options = 'dialogWidth=950px; dialogHeight=600px';
        var uri = '<?php echo Yii::app()->createUrl("Dialog/DialogSerial"); ?>';
        var w = window.showModalDialog(uri, arguments, options);
        
        $("#search_code").val(w);
    }
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">ซ่อมแซมสินค้า</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array(
                'name' => 'form1'
            )
        ));
        ?>
        <div>
            <div class="form-search">
                <label>serial code</label>
                <?php echo CHtml::textField('search_code', @$search_code, array(
                		'class' => 'form-control',
                		'style' => 'width: 200px'
                )); ?>
                <a href="#" class="btn btn-primary" onclick="return browseSerial()">
                    <i class="glyphicon glyphicon-search"></i>
                    ...
                </a>
                <a href="#" class="btn btn-primary" onclick="document.form1.submit()">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    แสดงรายการ
                </a>
                <a href="#" class="btn btn-success" onclick="startRepair()">
                    <i class="glyphicon glyphicon-cog"></i>
                    รับซ่อม
                </a>
            </div>
        </div>

        <?php if (!empty($product)): ?> 

            <!-- expire product -->
            <?php if (ProductSerial::getExpireStatus($productSerial['product_expire_date'])): ?>
                <div class="alert alert-danger">
                    <i class="icon icon-out"></i>
                    <strong>สินค้านี้หมดประกันแล้ว</strong>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <i class="icon icon-ok"></i>
                    <strong>สินค้ายังอยู่ในประกัน</strong>
                </div>
            <?php endif; ?>

            <div>
                <i class="icon icon-file"></i>
                <strong>ข้อมูลทั่วไป</strong>
            </div>
            <form>
                <div class="well well-small">
                    <div>
                        <?php echo $form->labelEx($product, 'product_code'); ?>
                        <?php
                        echo $form->textField($product, 'product_code', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px'
                        ));
                        ?>

                        <?php echo $form->labelEx($product, 'product_pack_barcode'); ?>
                        <?php
                        echo $form->textField($product, 'product_pack_barcode', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px'
                        ));
                        ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($product, 'product_name'); ?>
                        <?php
                        echo $form->textField($product, 'product_name', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 560px'
                        ));
                        ?>
                    </div>

                    <div>
                        <?php echo $form->labelEx($product, 'group_product_id'); ?>
                        <?php
                        if (!empty($product->group_product)) {
                            echo $form->textField($product, 'group_product_id', array(
                                'disabled' => 'disabled',
                                'class' => 'form-control',
                                'style' => 'width: 560px',
                                'value' => @$product->group_product->group_product_name
                            ));
                        } else {
                            echo $form->textField($product, 'group_product_id', array(
                                'disabled' => 'disabled',
                                'class' => 'form-control',
                                'style' => 'width: 560px',
                                'value' => 'ยังไม่ได้จัดกลุ่มให้สินค้านี้ / ข้อมูลหมวดสินค้านี้ถูกลบ'
                            ));
                        }
                        ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($product, 'product_detail'); ?>
                        <?php
                        echo $form->textField($product, 'product_detail', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 560px',
                        ));
                        ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($product, 'product_expire'); ?>
                        <?php
                        echo $form->textField($product, 'product_expire', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                            'value' => $product->getProductExpire()
                        ));
                        ?>

                        <?php echo $form->labelEx($productSerial, 'product_start_date'); ?>
                        <?php
                        echo $form->textField($productSerial, 'product_start_date', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                            'value' => Util::mysqlToThaiDate($productSerial->product_start_date)
                        ));
                        ?>

                        <?php echo $form->labelEx($productSerial, 'product_expire_date'); ?>
                        <?php
                        echo $form->textField($productSerial, 'product_expire_date', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                            'value' => Util::mysqlToThaiDate($productSerial->product_expire_date)
                        ));
                        ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($product, 'product_return'); ?>
                        <?php
                        echo $form->textField($product, 'product_return', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                            'value' => $product->getProductReturn()
                        ));
                        ?>
                        
                        <?php echo $form->labelEx($product, 'product_price'); ?>
                        <?php
                        echo $form->textField($product, 'product_price', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                        ));
                        ?>

                        <?php echo $form->labelEx($product, 'product_price_send'); ?>
                        <?php
                        echo $form->textField($product, 'product_price_send', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                        ));
                        ?>
                    </div>
                    <div>
                        <?php echo $form->labelEx($product, 'product_expire_date'); ?>
                        <?php
                        echo $form->textField($product, 'product_expire_date', array(
                            'disabled' => 'disabled',
                            'class' => 'form-control',
                            'style' => 'width: 200px',
                        ));
                        ?>
                    </div>
                </div>
            </form>

            <div>
                <i class="icon icon-tasks"></i>
                <strong>ประวัติการซ่อม</strong>
            </div>
            <div class="well well-small">
                <?php
                if (!empty($repairs)) {
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $repairs,
                        'columns' => array(
                            'user.user_name',
                            'repair_get_name',
                            'branch.branch_name',
                            array(
                                'name' => 'repair_date',
                                'value' => 'Util::mysqlToThaiDate($data->repair_date)'
                            ),
                            'repair_problem',
                            array(
                                'name' => 'repair_complete_date',
                                'value' => 'Util::mysqlToThaiDate($data->repair_complete_date)'
                            ),
                            array(
                                'name' => 'repair_status',
                                'value' => '$data->getStatus()'
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{btn_view} {btn_edit} {btn_delete}',
                                'buttons' => array(
                                    'btn_view' => array(
                                        'label' => '<i class="icon icon-white icon-folder-open"></i> เปิดดู',
                                        'url' => 'Yii::app()->createUrl("Basic/RepairView", array(
                                            "repair_id" => $data->repair_id,
                                            "serial_code" => $data->serial_no
                                        ))',
                                        'options' => array(
                                            'class' => 'btn btn-success',
                                            'title' => 'เปิดดู'
                                        )
                                    ),
                                    'btn_edit' => array(
                                        'label' => '<i class="icon icon-white icon-edit"></i> แก้ไข',
                                        'url' => 'Yii::app()->createUrl("Basic/StartRepair", array(
                                            "serial_code" => $data->serial_no,
                                            "repair_id" => $data->repair_id
                                        ))',
                                        'options' => array(
                                            'class' => 'btn btn-primary',
                                            'title' => 'แก้ไข'
                                        )
                                    ),
                                    'btn_delete' => array(
                                        'label' => '<i class="icon icon-white icon-trash"></i> ลบ',
                                        'options' => array(
                                            'class' => 'btn btn-danger',
                                            'title' => 'ลบ'
                                        )
                                    )
                                ),
                                'htmlOptions' => array(
                                    'style' => 'text-align: center',
                                    'width' => '240px'
                                )
                            )
                        )
                    ));
                }
                ?>
            </div>
        <?php endif; ?>

        <?php $this->endWidget(); ?>
    </div>
</div>