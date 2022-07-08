<?php
if(isset($_SESSION)){
    if($_SESSION['userLvl'] > 2){
        echo "<h2>HELLO! is it me you are looking for!</h2>";
    }else{
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
}else{
    header("location: ".SITE_ROOT."?error=illegalaccess");
}