<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('booster.widgets.TbButtonColumn');
Yii::import('application.components.AdminIdentity');

/**
 * Description of MyActionButtonColumn
 *
 * @author Admin
 */
class MyActionButtonColumn extends TbButtonColumn {

    protected function initDefaultButtons() {
        $validate_buttons = array(
            'view' => array(
                //'visible' => 'UserIdentity::checkAccess(NULL, "'.strtolower($this->grid->dataProvider->modelClass).'", "view")'
            ),
            'update' => array(
               // 'visible' => 'UserIdentity::checkAccess(NULL, "'.strtolower($this->grid->dataProvider->modelClass).'", "update")'
            ),
            'delete' => array(
               // 'visible' => 'UserIdentity::checkAccess(NULL, "'.strtolower($this->grid->dataProvider->modelClass).'", "delete")'
            )
        );
        $this->buttons = array_merge($this->buttons, $validate_buttons);
        parent::initDefaultButtons();
    }
}
