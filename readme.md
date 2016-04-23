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

   

