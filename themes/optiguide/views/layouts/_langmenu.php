<?php

echo CHtml::beginForm('', 'post', array('id' => 'langform'));

$currentLang = Yii::app()->language;
if ($currentLang == 'en') {
    $displang = 'Français';
    $changelang = 'fr';
} else {
    $displang = 'English';
    $changelang = 'en';
}
echo CHtml::link($displang, 'javascript:void(0);', array('onclick' => "document.getElementById('langform').submit();"));
echo CHtml::hiddenField('_lang', $changelang, array());

echo CHtml::endForm();
?>