<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'publicity-ads-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
             <div class="box-header">
                                <h3 class="box-title">Général</h3>
             </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NO_PUB', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NO_PUB', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'NO_PUB'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'CLIENT', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'CLIENT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRIX', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-2">
                        <?php echo $form->textField($model, 'PRIX', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'PRIX'); ?>
                    </div>
                     <?php echo $form->labelEx($model, 'PAYE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-2">                      
                         <?php echo $form->radioButtonList($model, 'PAYE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'PAYE'); ?>
                    </div>
                </div>

            <div class="box-header">
                                <h3 class="box-title">Publicité</h3>
             </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LANGUE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LANGUE', array('class' => 'form-control', 'size' => 2, 'maxlength' => 2)); ?>
                        <?php echo $form->error($model, 'LANGUE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'TITRE'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRIORITE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                         <?php echo $form->radioButtonList($model, 'PRIORITE', array('1' => 'Par date', '0' => 'Par nombre d\'impressions '), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'PRIORITE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DATE_DEBUT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'DATE_DEBUT', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'DATE_DEBUT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DATE_FIN', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                       <?php echo $form->textField($model, 'DATE_FIN', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'DATE_FIN'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_FICHIER', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ID_FICHIER', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ID_FICHIER'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LIEN_URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_URL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'MOTS_CLES_RECHERCHE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'MOTS_CLES_RECHERCHE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'MOTS_CLES_RECHERCHE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NB_IMPRESSIONS_FAITES', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NB_IMPRESSIONS_FAITES', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'NB_IMPRESSIONS_FAITES'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NB_IMPRESSIONS', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NB_IMPRESSIONS', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'NB_IMPRESSIONS'); ?>
                    </div>
                </div>

               


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ZONE_AFFICHAGE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ZONE_AFFICHAGE', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ZONE_AFFICHAGE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_POSITION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ID_POSITION', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ID_POSITION'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'AFFICHER_ACCUEIL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'AFFICHER_ACCUEIL', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'AFFICHER_ACCUEIL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DATE_AJOUT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'DATE_AJOUT', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'DATE_AJOUT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ACCUEIL_SECTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ACCUEIL_SECTION', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ACCUEIL_SECTION'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>