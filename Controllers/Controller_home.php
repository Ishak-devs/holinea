<?php
class Controller_home extends Controller{

    public function action_home(){
        $model = Model::getModel();
        $data = [
            "nb"=>$model->getNbNobelPrizes(),
        ];
        $this->render("home",$data);
    }

    public function action_default(){
        $this->action_home();
    }
}
?>