<?php
    /**
         * This is a base controller which loads
         * models and views
         */
    class Controller
    {
        //load model
        public function model($model){
            //require model file
            require_once '../app/models/' .$model .'.php';
            //instantiate model
            return new $model();
        }

        //load view 
        public function view($view, $data = []){
            //check for the view file
            if(file_exists('../app/views/' .$view .'.php')){
                require_once '../app/views/' .$view .'.php';
            }elseif(file_exists('../rest/public/' .$view .'.php')){
                require_once '../rest/public/' .$view .'.php';
            }elseif(file_exists('../rest/documentation/' .$view .'.php')){
                require_once '../rest/documentation/' .$view .'.php';
            }else{
                //view doesnot exist
                die('View does not exist');
            }
        }
    }
    