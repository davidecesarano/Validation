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
		 * 
		 * 'uri' 		string/string-2/string_3
		 * 'url'		http://www.example.com
		 * 'word'		Word
		 * 'words'		Hello World (lettere e spazi)
		 * 'word_int'   Word1 (lettere e numeri interi)
		 * 'int'		123
		 * 'float'		1,234.56
		 * 'tel'		+39081
		 * 'text'		Hello world? (lettere, spazi, numeri e alcuni caratteri speciali:
		 * 				, . ( ) : ! @ & % ?)
		 * 'address'	Via Napoli, 10
		 * 'fc'			CSR... (codice fiscale italiano)
		 * 'date_dmy'	01-01-2016
		 * 'date_ymd'	2016-01-01
		 * 'email'		example@email.com
		 * 'username'	user (lettere, numeri, lunghezza da 5 a 15 caratteri e alcuni caratteri speciali:
		 * 				- . ; _ ! # @ -)
		 * 'password'	password (lettere, numeri, lunghezza da 5 a 15 caratterie alcuni cartteri speciali:
		 * 				- . ; _ ! # @)
		 */
		public $patterns = array(
			'uri' 		=> '[A-Za-z0-9-\/_]+',
			'url'		=> '[A-Za-z0-9-:.\/_]+',
			'word'		=> '[A-Za-z]+',
			'words'		=> '[a-zA-Z\s]+',
			'word_int'	=> '[A-Za-z0-9]+',
			'int'		=> '[0-9]+',
			'float'		=> '[[0-9\.,]+',
			'tel'		=> '[0-9+]+',
			'text'		=> '[A-Za-z0-9\s,.():;!@&%?]+',
			'address'	=> '[a-zA-Z0-9\s,()°-]+',
			'fc'		=> '[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]',
			'date_dmy'	=> '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
			'date_ymd'	=> '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
			'email'		=> '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+',
			'username'	=> '[A-Za-z0-9-.;_!#@]{5,15}',
			'password'	=> '[A-Za-z0-9-.;_!#@]{5,15}'
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
		 * Pattern da applicare al riconoscimento
		 * dell'espressione regolare
		 * 
		 * @param string $name nome del pattern
		 * @return this
		 */
		public function pattern($name){
			
			$regex = '/^('.$this->patterns[$name].')$/';
			if(!preg_match($regex, $this->value)){
				$this->errors[] = 'Formato campo '.$this->name.' non valido.';
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
			
			$regex = '/^('.$pattern.')$/';
			if(!preg_match($pattern, $this->value)){
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
			
			if($this->value == '' || $this->value == null){
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
			
			if($this->value < $min || strlen($this->value) < $min){
				$this->errors[] = 'Valore campo '.$this->name.' inferiore al valore minimo';
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
			
			if($this->value > $max || strlen($this->value) > $max){
				$this->errors[] = 'Valore campo '.$this->name.' superiore al valore massimo';
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
		
	}