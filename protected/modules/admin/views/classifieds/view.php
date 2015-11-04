<?php
/* @var $this CalendarEventsController */
/* @var $model CalendarEvents */

$this->title = Myclass::t('OGO210', '', 'og');
$this->breadcrumbs = array(
    Myclass::t('OGO206', '', 'og') => array('index'),
    $this->title,
);
?>
<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
            array(
                'label' => Myclass::t('OGO208', '', 'og'),
                'value' => $model->classifiedCategory->classified_category_name_FR,
            ),
            'language',
            'classified_title',
            array(
                'label' => Myclass::t('OGO211', '', 'og'),
                'type'=>'raw',
                'value' => $model->classified_message
            ),
            'created_at',
            'modified_at',
        ),
    ));
    ?>
</div>