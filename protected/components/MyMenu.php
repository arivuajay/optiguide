<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii :: import('zii.widgets.CMenu');
Yii::import('application.components.AdminIdentity');

class MyMenu extends CMenu {

    public function init() {
        $_id = NULL;
        $_controller = Yii::app()->controller->id;
        $_action = Yii::app()->controller->action->id;
        $ignore_list = $this->ignoreActiveList();

        $parent_active = array();
        for($i = 0; $i < count($this->items); $i++){
            $parent_active[$i] = $i == 0 ? 1 : 0;
        }
       
        foreach ($this->items as $key => $main_item) {
               
           if ( isset($main_item['url']) )  
            {
                $controller = $this->splitController($main_item['url'][0]);
                $is_visible = AdminIdentity::checkAccess($_id, $controller, 'view');    
                $this->items[$key]['visible'] = $is_visible;
                if(empty($main_item['items']) && $is_visible)
                {
                    $parent_active[$key] = 1;
                }    
            } 
            
            foreach ($main_item as $second_key => $second_item) {
               
                if (is_array($second_item)) {
              
                    foreach ($second_item as $third_key => $third_item) {
                  
                        if (isset($third_item['url'])) {
                            
                            $controller = $this->splitController($third_item['url'][0]);
                            if (is_array($third_item['url'])) {                               
                               
                                $othercontrollers = array("exportDatas","paymentTransaction","supplierSubscriptionPrice");
                                if(in_array($controller , $othercontrollers))
                                {                                     
                                    $action = $this->splitAction($third_item['url'][0]);                                    
                                }  else {
                                    $action = "view";
                                }
                               
                                $is_visible = AdminIdentity::checkAccess($_id, $controller, $action);
                                $this->items[$key][$second_key][$third_key]['visible'] = $is_visible;
                                if (!in_array($_controller, $ignore_list) && !in_array($controller, $ignore_list)) {
//                                    $this->items[$key][$second_key][$third_key]['active'] = $_controller == $controller;
                                }
                                if ($is_visible) {
                                    $parent_active[$key] = 1;
                                }
                            }
                            
                            if (isset($third_item['items'])) {
                                foreach ($third_item['items'] as $fourth_key => $fourth_value) {
                                   
                                    $controller = $this->splitController($fourth_value['url'][0]);
                                    $othercontrollers = array("exportDatas","paymentTransaction");
                                    if(in_array($controller , $othercontrollers))
                                    {                                    
                                        $action = $this->splitAction($third_item['url'][0]);                                    
                                    }  else {
                                        $action = "view";
                                    }
                                   
                                    $is_visible = AdminIdentity::checkAccess($_id, $controller, $action);
                                    $this->items[$key][$second_key][$third_key]['items'][$fourth_key]['visible'] = $is_visible;
                                    if (!in_array($_controller, $ignore_list) && !in_array($controller, $ignore_list)) {
//                                        $this->items[$key][$second_key][$third_key]['items'][$fourth_key]['active'] = $_controller == $controller;
                                    }
                                    if ($is_visible) {
                                        $parent_active[$key] = 1;
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }
            
        }
//exit;
        //Check All inside menus are active or not
        foreach ($this->items as $key => $main_item) {
            $this->items[$key]['visible'] = $parent_active[$key];
        }
//        echo "<pre>";
//      print_r($this->items);
//      exit;
        parent::init();
    }

    /*Split menu controller name*/
    public function splitController($url) {
        $exp = explode("/", $url);
        if (count($exp) == 1) {
            $controller = Yii::app()->controller->id;
        } else {
            $controller = $exp[2];
        }       
        //end
        return $controller;
    }

    /* These are ignored list for visible / active ckecking. we are checking visible / active condition (_sidenavebar.php) directly*/
    public static function ignoreActiveList() {
        return array('group', 'publishergroup', 'work');
    }
    
     /*Split menu controller name*/
    public function splitAction($url) {
        
        $exp = explode("/", $url);
     
        if (count($exp) == 2) {
            $action = Yii::app()->action->id;
        } else {
            $action = $exp[3];
        }
        
        return $action;
    }

}
