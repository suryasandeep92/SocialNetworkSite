<?php
ob_start(); //Turns on output buffering 
session_start();

$timezone = date_default_timezone_set("Canada/Newfoundland");

$con = mysqli_connect("localhost", "root", "", "csc"); //Connection variable will be used all over the project

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>