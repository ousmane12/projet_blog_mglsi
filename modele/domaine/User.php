<?php
    class User {

        private $id;
        private $login;
        private $password;
    
        /**
         * @return mixed
         */
        public function getId() {
            return $this->id;
        }
    
        /**
         * @param mixed $id
         *
         * @return self
         */
        public function setId($id) {
            $this->id = $id;
    
            return $this;
        }
    
        /**
         * @return mixed
         */
        public function getLogin() {
            return $this->login;
        }
    
        /**
         * @param mixed $login
         *
         * @return self
         */
        public function setLogin($login) {
            $this->login = $login;
    
            return $this;
        }
    
        /**
         * @return mixed
         */
        public function getPassword() {
            return $this->password;
        }
    
        /**
         * @param mixed $password
         *
         * @return self
         */
        public function setPassword($password) {
            $this->password = $password;
    
            return $this;
        }
    }
    