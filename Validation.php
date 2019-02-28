<?php
    
    /**
     * Validation 
     *
     * Semplice classe PHP per la validazione.
     *
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @copyright (c) 2016, Davide Cesarano
     * @license https://github.com/davidecesarano/Validation/blob/master/LICENSE MIT License
     * @link https://github.com/davidecesarano/Validation
     */
     
    class Validation {
        
        /**
         * @var array $patterns
         */
        public $patterns = array(
            'uri'           => '[A-Za-z0-9-\/_?&=]+',
            'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
            'alpha'         => '[\p{L}]+',
            'words'         => '[\p{L}\s]+',
            'alphanum'      => '[\p{L}0-9]+',
            'int'           => '[0-9]+',
            'float'         => '[0-9\.,]+',
            'tel'           => '[0-9+\s()-]+',
            'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
            'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
            'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
            'address'       => '[\p{L}0-9\s.,()°-]+',
            'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
            'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
            'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]'
        );
        
        /**
         * @var array $errors
         */
        public $errors = array();
        
        /**
         * Nome del campo
         * 
         * @param string $name
         * @return this
         */
        public function name($name){
            
            $this->name = $name;
            return $this;
        
        }
        
        /**
         * Valore del campo
         * 
         * @param mixed $value
         * @return this
         */
        public function value($value){
            
            $this->value = $value;
            return $this;
        
        }
        
        /**
         * File
         * 
         * @param mixed $value
         * @return this
         */
        public function file($value){
            
            $this->file = $value;
            return $this;
        
        }
        
        /**
         * Pattern da applicare al riconoscimento
         * dell'espressione regolare
         * 
         * @param string $name nome del pattern
         * @return this
         */
        public function pattern($name){
            
            if($name == 'array'){
                
                if(!is_array($this->value)){
                    $this->errors[] = 'Formato campo '.$this->name.' non valido.';
                }
            
            }else{
            
                $regex = '/^('.$this->patterns[$name].')$/u';
                if($this->value != '' && !preg_match($regex, $this->value)){
                    $this->errors[] = 'Formato campo '.$this->name.' non valido.';
                }
                
            }
            return $this;
            
        }
        
        /**
         * Pattern personalizzata
         * 
         * @param string $pattern
         * @return this
         */
        public function customPattern($pattern){
            
            $regex = '/^('.$pattern.')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'Formato campo '.$this->name.' non valido.';
            }
            return $this;
            
        }
        
        /**
         * Campo obbligatorio
         * 
         * @return this
         */
        public function required(){
            
            if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
                $this->errors[] = 'Campo '.$this->name.' obbligatorio.';
            }            
            return $this;
            
        }
        
        /**
         * Lunghezza minima
         * del valore del campo
         * 
         * @param int $min
         * @return this
         */
        public function min($length){
            
            if(is_string($this->value)){
                
                if(strlen($this->value) < $length){
                    $this->errors[] = 'Valore campo '.$this->name.' inferiore al valore minimo';
                }
           
            }else{
                
                if($this->value < $length){
                    $this->errors[] = 'Valore campo '.$this->name.' inferiore al valore minimo';
                }
                
            }
            return $this;
            
        }
            
        /**
         * Lunghezza massima
         * del valore del campo
         * 
         * @param int $max
         * @return this
         */
        public function max($length){
            
            if(is_string($this->value)){
                
                if(strlen($this->value) > $length){
                    $this->errors[] = 'Valore campo '.$this->name.' superiore al valore massimo';
                }
           
            }else{
                
                if($this->value > $length){
                    $this->errors[] = 'Valore campo '.$this->name.' superiore al valore massimo';
                }
                
            }
            return $this;
            
        }
        
        /**
         * Confronta con il valore di
         * un altro campo
         * 
         * @param mixed $value
         * @return this
         */
        public function equal($value){
        
            if($this->value != $value){
                $this->errors[] = 'Valore campo '.$this->name.' non corrispondente.';
            }
            return $this;
            
        }
        
        /**
         * Dimensione massima del file 
         *
         * @param int $size
         * @return this 
         */
        public function maxSize($size){
            
            if($this->file['error'] != 4 && $this->file['size'] > $size){
                $this->errors[] = 'Il file '.$this->name.' supera la dimensione massima di '.number_format($size / 1048576, 2).' MB.';
            }
            return $this;
            
        }
        
        /**
         * Estensione (formato) del file
         *
         * @param string $extension
         * @return this 
         */
        public function ext($extension){

            if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
                $this->errors[] = 'Il file '.$this->name.' non è un '.$extension.'.';
            }
            return $this;
            
        }
        
        /**
         * Purifica per prevenire attacchi XSS
         *
         * @param string $string
         * @return $string
         */
        public function purify($string){
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
        
        /**
         * Campi validati
         * 
         * @return boolean
         */
        public function isSuccess(){
            if(empty($this->errors)) return true;
        }
        
        /**
         * Errori della validazione
         * 
         * @return array $this->errors
         */
        public function getErrors(){
            if(!$this->isSuccess()) return $this->errors;
        }
        
        /**
         * Visualizza errori in formato Html
         * 
         * @return string $html
         */
        public function displayErrors(){
            
            $html = '<ul>';
                foreach($this->getErrors() as $error){
                    $html .= '<li>'.$error.'</li>';
                }
            $html .= '</ul>';
            
            return $html;
            
        }
        
        /**
         * Visualizza risultato della validazione
         *
         * @return booelan|string
         */
        public function result(){
            
            if(!$this->isSuccess()){
               
                foreach($this->getErrors() as $error){
                    echo "$error\n";
                }
                exit;
                
            }else{
                return true;
            }
        
        }
        
        /**
         * Verifica se il valore è
         * un numero intero
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_int($value){
            if(filter_var($value, FILTER_VALIDATE_INT)) return true;
        }
        
        /**
         * Verifica se il valore è
         * un numero float
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_float($value){
            if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
        }
        
        /**
         * Verifica se il valore è
         * una lettera dell'alfabeto
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_alpha($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
        }
        
        /**
         * Verifica se il valore è
         * una lettera o un numero
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_alphanum($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
        }
        
        /**
         * Verifica se il valore è
         * un url
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_url($value){
            if(filter_var($value, FILTER_VALIDATE_URL)) return true;
        }
        
        /**
         * Verifica se il valore è
         * un uri
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_uri($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
        }
        
        /**
         * Verifica se il valore è
         * true o false
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_bool($value){
            if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
        }
        
        /**
         * Verifica se il valore è
         * un'e-mail
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_email($value){
            if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
        }
        
    }