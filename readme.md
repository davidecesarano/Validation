## Simple PHP class for Validation

This PHP class is useful to validate an HTML form fields.

### Typical Use

	$email = 'example@email.com';
    $username = 'admin';
    $password = 'test';
    $age = 29;
    
    $val = new Validation();
	$val->name('email')->value($email)->pattern('email')->required();
    $val->name('username')->value($username)->pattern('username')->required();
    $val->name('password')->value($password)->customPattern('[A-Za-z0-9-.;_!#@]{5,15}')->required();
    $val->name('age')->value($password)->min(18)->max(40);
    
    if($val->isSuccess()){
    	echo "Validation ok!";
    }else{
    	echo "Validation error!";
        var_dump($val->getErrors());
    }

### Form HTML Use

	<?php $val = new Validation; ?>
    
    <form method="post" action="#">
    	<label for="name">Name:</label>
        <input type="text" name="name" pattern="<?php echo $validation->patterns['words']; ?>" required>
        <label for="email">E-Mail:</label>
        <input type="email" name="email" required>
        <label for="tel">Telephone:</label>
        <input type="text" name="tel" pattern="<?php echo $validation->patterns['tel']; ?>">
        <label for="message">Message:</label>
        <textarea name="message" cols="40" rows="6" required></textarea>
        <button type="submit">Send</button>
    </form>
    
    if(!empty($_POST)){
    	
        $val->name('Name')->value($_POST['name'])->pattern('words')->required();
        $val->name('E-Mail')->value($_POST['email'])->pattern('email')->required();
        $val->name('Telephone')->value($_POST['tel'])->pattern('tel');
        $val->name('Message')->value($_POST['message'])->pattern('text')->required();
        
        if($val->isSuccess()){
        	echo 'Validation ok!';        
        }else{
        	echo $val->displayErrors();
        }
        
    }

### Methods

| Method        | Parameter | Description                                                | Example                   |
|---------------|-----------|------------------------------------------------------------|---------------------------|
| name          | $name     | Field name.                                                | name('Name')              |
| value         | $value    | Field value.                                               | value('Test')             |
| pattern       | $pattern  | Field pattern.                                             | pattern('text')           |
| customPattern | $pattern  | Field custom pattern.                                      | customPattern('[A-Za-z]') |
| required      |           | Field required.                                            | required()                |
| min           | $length   | Minimum length field.                                      | min(10)                   |
| max           | $length   | Maximum length field.                                      | max(10)                   |
| equal         | $value    | Return an error if the input is not same as the parameter. | equal($value)             |
   

