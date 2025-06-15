<?php
$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$hostdatabase = "pra_ujikom_laundry";
$config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);

if (!$config) {
    echo "Connection Failed";
}