## Simple PHP class for Validation

This PHP class is useful to validate an HTML form fields.

### Usage

	require_once('Validation.php');

### Typical Use

	$email = 'example@email.com';
    $username = 'admin';
    $password = 'test';
    $age = 29;
    
    $val = new Validation();
	$val->name('email')->value($email)->pattern('email')->required();
    $val->name('username')->value($username)->pattern('username')->required();
    $val->name('password')->value($password)->customPattern('[A-Za-z0-9-.;_!#@]{5,15}')->required();
    $val->name('age')->value($age)->min(18)->max(40);
    
    if($val->isSuccess()){
    	echo "Validation ok!";
    }else{
    	echo "Validation error!";
        var_dump($val->getErrors());
    }

### Simple Form HTML Use

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
    
    <?php 
    	
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
  
    ?>

### Methods

| Method          | Parameter | Description                                                                 | Example                   |
|-----------------|-----------|-----------------------------------------------------------------------------|---------------------------|
| name            | $name     | Return field name                                                           | name('Name')              |
| value           | $value    | Return value field                                                          | value('Test')             |
| pattern         | $pattern  | Return an error if the input has a different format than the pattern        | pattern('text')           |
| customPattern   | $pattern  | Return an error if the input has a different format than the custom pattern | customPattern('[A-Za-z]') |
| required        |           | Returns an error if the input is empty                                      | required()                |
| min             | $length   | Return an error if the input is shorter than the parameter                  | min(10)                   |
| max             | $length   | Return an error if the input is longer than the parameter                   | max(10)                   |
| equal           | $value    | Return an error if the input is not same as the parameter                   | equal($value)             |
| isSuccess       |           | Return true if there are no errors                                          | isSuccess()               |
| getErrors       |           | Return un array with validation errors                                      | getErrors()               |
| displayErrors() |           | Return Html errors                                                          | displayErrors()           |
| is_int() 		  |           | Return true if the value is an integer number                               | is_int($value)            |

### Patterns

| Name     | Description                                                        | Example                           |
|----------|--------------------------------------------------------------------|-----------------------------------|
| uri      | Url without file extension                                         | folder-1/folder-2                 |
| url      | Uri with file extension                                            | http://www.example.com/myfile.gif |
| word     | Only letters                                                       | World                             |
| words    | Letters with space                                                 | Hello World                       |
| word_int | Alpha-numeric characters                                           | test2016                          |
| int      | Integer number format                                              | 154                               |
| float    | Float number format                                                | 1,234.56                          |
| tel      | Telephone number                                                   | +3908177777                       |
| text     | Alpha-numeric and some special characters, spaces                  | Test1 ,.():;!@&%?                 |
| address  | Address format                                                     | Street Name, 99                   |
| fc       | Fiscal Code (only for italians)                                    | CSR...                            |
| date_dmy | Date in format dd-MM-YYYY                                          | 01-01-2016                        |
| date_ymd | Date in format YYYY-MM-dd                                          | 2016-01-01                        |
| email    | E-Mail format                                                      | exampe@email.com                  |
| username | Alpha-numeric and some special characters. Length between 5 and 15 | user1-._!#@                       |
| password | Alpha-numeric and some special characters. Length between 5 and 15 | pass1-._!#@                       |
