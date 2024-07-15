<?php

/* Add language files 
   Available languages: de, en, es, fr, it, pl, pt, ru */
   
require_once 'LANG/en.php';

/**
 * Validation
 *
 * Simple PHP class for validation.
 *
 * @package Core
 * @author Davide Cesarano <davide.cesarano@unipegaso.it>
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
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}'
    );

    /**
     * @var array $errors
     */
    public $errors = array();

    /**
     * @var mixed $value
     */
    public $value = null;

    /**
     * @var string $name
     */
    public $name = null;

    /**
     * @var mixed $file
     */
    public $file = null;
    

    /**
     * Field name
     *
     * @param string $name
     * @return self
     */
    public function name(string $name) : Validation
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Field value
     *
     * @param mixed $value
     * @return self
     */
    public function value($value) : Validation
    {
        $this->value = $value;
        return $this;
    }

    /**
     * File
     *
     * @param mixed $value
     * @return self
     */
    public function file($value) : Validation
    {
        $this->file = $value;
        return $this;
    }

    /**
     * Pattern to be used for regular expression matching
     *
     * @param string $name pattern name
     * @return self
     */
    public function pattern(string $name) : Validation
    {

        if($name == 'array'){

            if(!is_array($this->value)){
                $this->errors[$this->name] = array('error' => "val_pattern");
            }

        }elseif($name == 'email'){
          if($this->value != '' && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){

              $this->errors[$this->name] = array('error' => "val_pattern");
          }
        }
        else{

            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[$this->name] = array('error' => "val_pattern");
            }

        }
        return $this;
    }

    /**
     * Custom pattern
     *
     * @param string $pattern
     * @return self
     */
    public function customPattern(string $pattern) : Validation
    {
        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)){
            $this->errors[$this->name] = array('error' => "val_pattern");
        }
        return $this;
    }

    /**
     * Required field
     *
     * @return self
     */
    public function required() : Validation
    {
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[$this->name] = array('error' => "val_required");
        }
        return $this;
    }

    /**
     * Minimum length of field value
     *
     * @param int $min
     * @return self
     */
    public function min(int $length) : Validation
    {
        if(is_string($this->value)){

            if(strlen($this->value) < $length){
                $this->errors[$this->name] = array('error' => "val_min");
            }

        }else{

            if($this->value < $length){
                $this->errors[$this->name] = array('error' => "val_min");
            }

        }
        return $this;
    }

    /**
     * Maximum length of field value
     *
     * @param int $max
     * @return self
     */
    public function max($length) : Validation
    {
        if(is_string($this->value)){

            if(strlen($this->value) > $length){
                $this->errors[$this->name] = array('error' => "val_max");
            }

        }else{

            if($this->value > $length){
                $this->errors[$this->name] = array('error' => "val_max");
            }

        }
        return $this;
    }

    /**
     * Compare with the value of another field
     *
     * @param mixed $value
     * @return self
     */
    public function equal($value) : Validation
    {
        if($this->value != $value){
            $this->errors[$this->name] = array('error' => "val_equal");
        }
        return $this;
    }

    /**
     * Maximum file size
     *
     * @param int $size
     * @return self
     */
    public function maxSize(int $size) : Validation
    {
        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[$this->name] = array('error' => "val_file_max_size", 'size' => number_format($size / 1048576, 2));
        }
        return $this;
    }

    /**
     * File extension
     *
     * @param string $extension
     * @return self
     */
    public function ext(string $extension) : Validation
    {
        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            $this->errors[$this->name] = array('error' => "val_file_ext", 'ext' => $extension);
        }
        return $this;
    }

    /**
     * Sanitize against XSS attacks
     *
     * @param string $string
     * @return $string
     */
    public function purify(string $string) : string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Check if fields are valid
     *
     * @return boolean
     */
    public function isSuccess() : bool
    {
        return empty($this->errors);
    }

    /**
     * Validation errors
     *
     * @return array $this->errors
     */
    public function getErrors() : array|null
    {
        if(!$this->isSuccess()){
            return $this->errors;
        }else{
            return null;
        }
    }

    /**
     * Display errors in HTML format
     *
     * @return string $html
     */
    public function displayErrors() : string
    {
        $html = '<ul>';
            foreach($this->getErrors() as $name => $error){
                $html .= '<li>'.$name." - ".LANG['val_errors'][$error['error']].'</li>';
            }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Display validation result
     *
     * @return void
     */
    public function result() : void
    {
        if(!$this->isSuccess()){
            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
        }
    }

    /**
     * Check if value is an integer
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_int($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_INT)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is a float
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_float($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_FLOAT)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is an alphabetic character
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alpha($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is an alphanumeric character
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alphanum($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is a URL
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_url($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_URL)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is a URI
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_uri($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_?&=]+$/")))){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is true or false
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_bool($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if value is an email address
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_email($value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }

}
