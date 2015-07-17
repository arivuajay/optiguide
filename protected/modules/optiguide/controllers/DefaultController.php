<?php

class DefaultController extends OGController {

    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionSubscribe(){
        $this->render('subscribe');
    }

}
