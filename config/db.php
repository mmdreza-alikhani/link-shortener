<?php

$con = new mysqli('localhost', 'root', '', 'link-shortener');
if($con->connect_error){
    die("connection error: $con->connect_error");
}
