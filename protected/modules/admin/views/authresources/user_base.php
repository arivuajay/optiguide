<?php
$this->title = 'User Privilage';
$this->breadcrumbs = array(
    'Users' => array('/admin/user/index'),
    $this->title
);
?>
<div class="user-create">

    <div class="master-role-form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-privl-form',
            'htmlOptions' => array('role' => 'form')
        ));
        ?>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_User_ID') ?>
                    <?php $names = CHtml::listData(User::model()->slaves()->with('roleMdl')->findAll(array('order' => 'name')), 'id', 'username') ?>
                    <?php
                    echo $form->dropDownList($model, 'Master_User_ID', $names, array(
                        'prompt' => 'Choose User',
                        'class' => 'form-control',
                        'onchange' => '{'
                        . '$("#AuthResources_Master_Module_ID").val("");'
                        . '$("#resources-block").html("");'
                        . '}'
                    ));
                    ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Module_ID') ?>
                    <?php $modules = Myclass::getMasterModule() ?>
                    <?php
                    echo $form->dropDownList($model, 'Master_Module_ID', $modules, array(
                        'prompt' => 'Choose Module',
                        'class' => 'form-control',
                        'onchange' => '{'
                        . 'if($("#AuthResources_Master_User_ID").val() != "" && this.value != ""){'
                        . '$("#ajax-loader").show();'
                        . '$("#resources-block").hide();'
                        . '$.get("' . Yii::app()->createUrl("site/authresources/getscreensbymodule") . '", { 
                            type: "user", 
                            mid: this.value, 
                            id: $("#AuthResources_Master_User_ID").val() }
                            ).done(function( data ){
                                $("#ajax-loader").hide();
                                $("#resources-block").html( data );
                                $(".chkbox").iCheck({
                                    checkboxClass: "icheckbox_minimal",
                                    radioClass: "iradio_minimal"
                                });
                                $(".all_check").on("ifChecked", function(event){
                                    _class = $(this).data("check");
                                    $("."+_class).iCheck("check");
                                });
                                $(".all_check").on("ifUnchecked", function(event){
                                    _class = $(this).data("check");
                                    $("."+_class).iCheck("uncheck");
                                });
                                $(".check_view").on("ifUnchecked", function(event){
                                    _class = $(this).data("chbx");
                                    $("."+_class).iCheck("uncheck");
                                });
                                $(".check_add, .check_update, .check_delete").on("ifChecked", function(event){
                                    _class = $(this).data("chbx");
                                    $(".check_view."+_class).iCheck("check");
                                });
                                $("#resources-block").show();
                           });'
                        . '}else{'
                        . '$("#resources-block").html("");'
                        . '$("#resources-block").show();'
                        . '}'
                        . '}'
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

        <div id="ajax-loader" class="text-center" style="display: none">
            <?= CHtml::image($this->themeUrl . '/img/ajax-loader1.gif'); ?>
        </div>

        <div id="resources-block">
        </div>
    </div>
</div>