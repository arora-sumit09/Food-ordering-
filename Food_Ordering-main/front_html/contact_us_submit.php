<?php
include("../dbconnect.php");
include("../constant.php");
    $name=$_POST['name'];
    $email=$_POST['email'];
    $number=$_POST['number'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    $added_on=date('Y-m-d');
    mysqli_query($conn,"insert into contact_us(name,email,mobile,subject,message,added_on,status) values('$name','$email','$number','$subject','$message','$added_on','1')");
    echo "Thank You for contacting! We will get back to you.";
?>