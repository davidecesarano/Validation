## Simple PHP class for Validation

This PHP class is useful to validate an HTML5 form fields.

## Typical Use


	$val = new Validation();
	$val->name('email')->value($_POST['email'])->pattern('email')->required();
    $val->name('username')->value($_POST['username'])->pattern('username')->required();
    $val->name('password')->value($_POST['password'])->customPattern()->required();
    $val->name('age')->value($_POST['age'])->min(18)->max(40);
    
    if($val->isSuccess()){
    	echo "Validation ok!";
    }else{
    	echo "Validation error!";
        var_dump($val->getErrors());
    }

