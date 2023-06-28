<?php
session_start();
include "db.php";

if(isset($_POST['username']) && isset($_POST['password']))
{
    function validate($data)
    {
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
    }
}
$uname= validate($_POST['username']);
$pass= validate($_POST['password']);

$sql= "SELECT * FROM admin WHERE admin_id='$uname' AND password='$pass' AND admin_check=1";

$result= mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1)
{
    $row= mysqli_fetch_assoc($result);
    if($row['admin_id'] === $uname && $row['password'] === $pass)
    {
        echo "Logged In!";
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_name'];
        header("Location: dashboard.php");
        exit();
    }
    else
    {
        echo("<script>window.location = 'index.php';</script>");
        header("Location: index.php?error=Incorrect User Name or Password");
        exit();
    }
}
else
{
    echo("<script>alert('No User Found!')</script>");
    echo("<script>window.location = 'index.php';</script>");
    // header("Location: index.html");
    exit();
}
