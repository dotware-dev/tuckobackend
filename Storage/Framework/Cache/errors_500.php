<?php class_exists('Core\Template') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Framework - </title>
    
    <!--Scripts, styles, etc. required in all the pages-->
    
    <!--Block for specific scripts, styles, etc.-->
    
</head>
<body>
    <nav>
        <a href="<?php echo $url_basis ?>signup">Signup</a> | 
        <a href="<?php echo $url_basis ?>">Home</a> | 
        <a href="<?php echo $url_basis ?>login">Login</a>
    </nav>
    
    <h1>ERROR 500</h1>
    <p>Internal server error</p>

</body>
</html>

