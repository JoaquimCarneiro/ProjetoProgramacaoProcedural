<?php
if(isset($_SESSION)){
    if($_SESSION['userLvl'] > 2){
        echo "ok";
    }else{
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
}else{
    header("location: ".SITE_ROOT."?error=illegalaccess");
}