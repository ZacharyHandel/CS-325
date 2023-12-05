<?php
    $name = $_POST['person'];    //GET is super global (is seen everywhere)

    if (empty($name))
        echo "<h2>Error: no data</h2>";
    else
        echo "<h2>Hello $name</h2>";
    //Run apache on XAMPP and copy over the files into the htdocs file
    //php -l hello.php (checks to see if syntax is correct)
    //go to browser with localhost/hello.html
    //disable cache which will fix the browser not knowing if we made a change
    //GET are sent as part of URL
        //GET /hello.php?person=Zach\r\n
        //Considered insecure, but in reality they are no more or less secure than POST
    //POST are sent as part of the request header
        //This is the way we usually do stuff because of search engine optimization
    //We have an XSS vulnerability
        //This one in particular is reflective XSS just because the data comes back to us
?>

