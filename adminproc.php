<?php

$conn=mysqli_connect("localhost" , "root" , "" , "event web");
$adminu=$_POST['admin_username'];
$adminp=$_POST['admin_password'];

$que="SELECT * FROM admin where admin_u = '$adminu' and admin_p = '$adminp'";
$result = mysqli_query($conn, $que);

if($result > 0){
    header("location:dashboard.php");
}
else{
    echo "Invalid Admin Credentials";
}



?>