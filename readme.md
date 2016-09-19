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
    $val->name('username')->value($username)->pattern('alpha')->required();
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
    	
          $val->name('name')->value($_POST['name'])->pattern('words')->required();
          $val->name('e-mail')->value($_POST['email'])->pattern('email')->required();
          $val->name('tel')->value($_POST['tel'])->pattern('tel');
          $val->name('message')->value($_POST['message'])->pattern('text')->required();

          if($val->isSuccess()){
              echo 'Validation ok!';        
          }else{
              echo $val->displayErrors();
          }

      }
  
    ?>

### Methods

| Method          | Parameter | Description                                                                 | Example                           |
|-----------------|-----------|-----------------------------------------------------------------------------|-----------------------------------|
| name            | $name     | Return field name                                                           | name('name')                      |
| value           | $value    | Return value field                                                          | value($_POST['name])              |
| file            | $value    | Return $_FILES array                                                        | file($_FILES['name'])             |
| pattern         | $pattern  | Return an error if the input has a different format than the pattern        | pattern('text')                   |
| customPattern   | $pattern  | Return an error if the input has a different format than the custom pattern | customPattern('[A-Za-z]')         |
| required        |           | Returns an error if the input is empty                                      | required()                        |
| min             | $length   | Return an error if the input is shorter than the parameter                  | min(10)                           |
| max             | $length   | Return an error if the input is longer than the parameter                   | max(10)                           |
| equal           | $value    | Return an error if the input is not same as the parameter                   | equal($value)                     |
| maxSize         | $value    | Return an error if the file size exceeds the maximum allowable size         | maxSize(3145728)                  |
| ext             | $value    | Return an error if the file extension is not same the parameter             | ext('pdf')                        |
| isSuccess       |           | Return true if there are no errors                                          | isSuccess()                       |
| getErrors       |           | Return an array with validation errors                                      | getErrors()                       |
| displayErrors   |           | Return Html errors                                                          | displayErrors()                   |
| result          |           | Return true if there are no errors or html errors                           | result()                          |
| is_int		  | $value    | Return true if the value is an integer number                               | is_int(1)                         |
| is_float	      | $value    | Return true if the value is an float number                                 | is_float(1.1)                     |
| is_alpha	      | $value    | Return true if the value is an alphabetic characters                        | is_alpha('test')                  |
| is_alphanum     | $value    | Return true if the value is an alphanumeric characters                      | is_alphanum('test1')              |
| is_url          | $value    | Return true if the value is an url (protocol is required)                   | is_url('http://www.example.com')  |
| is_uri          | $value    | Return true if the value is an uri (protocol is not required)               | is_uri('www.example.com')         |
| is_bool 	      | $value    | Return true if the value is an boolean                                      | is_bool(true)                     |
| is_email 	      | $value    | Return true if the value is an e-mail                                       | is_email('email@email.com')       |

### Patterns

| Name     | Description                                                        | Example                           |
|----------|--------------------------------------------------------------------|-----------------------------------|
| uri      | Url without file extension                                         | folder-1/folder-2                 |
| url      | Uri with file extension                                            | http://www.example.com/myfile.gif |
| alpha    | Only alphabetic characters                                         | World                             |
| words    | Alphabetic characters and spaces                                   | Hello World                       |
| alphanum | Alpha-numeric characters                                           | test2016                          |
| int      | Integer number                                                     | 154                               |
| float    | Float number                                                       | 1,234.56                          |
| tel      | Telephone number                                                   | (+39) 081-777-77-77               |
| text     | Alpha-numeric characters, spaces and some special characters       | Test1 ,.():;!@&%?                 |
| file     | File name format						        | myfile.png                        |
| folder   | Folder name format						        | my_folde		            |
| address  | Address format                                                     | Street Name, 99                   |
| date_dmy | Date in format dd-MM-YYYY                                          | 01-01-2016                        |
| date_ymd | Date in format YYYY-MM-dd                                          | 2016-01-01                        |
| email    | E-Mail format                                                      | exampe@email.com                  |
