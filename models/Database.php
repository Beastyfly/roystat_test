<?php

namespace models;

class Database
{
    private $host = "localhost";
    private $user = "u1874021_obito";
    private $pass = "360flipflip360";
    private $name = "u1874021_obito";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new \mysqli($this->host, $this->user, $this->pass, $this->name);
        } catch (\Exception $e) {
            echo "connection failde". $e-> getMessage();
        }
    }

    public function fetch(): bool|array|null
    {
        $query = "SELECT * FROM `roistat_db`";
        $sql = $this->conn->query($query);
        return mysqli_fetch_all($sql);
    }

    public function insert(): void
    {
        if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $price = (int)$_POST['price'];
                $date = date('d-m-Y-');

                include 'models/ApiFetch.php';
                $toAMO = new ApiFetch();
                $order = $toAMO->insertToAMO($name, $email, $tel, $price);
                if ($order > 0) {
                    $query = "INSERT INTO `roistat_db`(`id`, `name`, `email`, `tel`, `price`, `date`) VALUES (NULL,'$name', '$email', '$tel', '$price', '$date')";
                    if ($sql = $this->conn->query($query)) {

                    } else {
                        echo "<script> alert('ALERT')</script>";
                    }
                } else {
                    echo "<script> alert('ERROR')</script>";
                }
        }
    }
    public function updateToken($token, $time): void
    {
        $id = 2;
        $query = "UPDATE `token` SET `id`= '$id',`token`='$token',`date`='$time' WHERE `id`='$id'";
        if($sql = $this->conn->query($query)) {

        } else {
            echo "<script> alert('ALERT')</script>";
        }
    }
    public function updateRefreshToken($token, $time): void
    {
        $id = 3;
        $query = "UPDATE `token` SET `id`= '$id',`token`='$token',`date`='$time' WHERE `id`='$id'";
        if($sql = $this->conn->query($query)) {

        } else {
            echo "<script> alert('ALERT')</script>";
        }
    }
    public function  fetchToken()
    {
        $query = "SELECT * FROM `token` WHERE `id`=2";
        $sql = $this->conn->query($query);
        $token = mysqli_fetch_all($sql);
        return $token[0][1];
    }

    public function fetchRefreshToken()
    {
        $query = "SELECT * FROM `token` WHERE `id`=3";
        $sql = $this->conn->query($query);
        $token = mysqli_fetch_all($sql);
        return $token[0][1];
    }

    public function fetchTimeToken(){
        $query = "SELECT * FROM `token` WHERE `id`=3";
        $sql = $this->conn->query($query);
        $token = mysqli_fetch_all($sql);
        return $token[0][2];
    }
}