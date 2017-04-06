<?php
if(isset($_GET['save']))
{
    unlink("./saved/".$_GET['delete_file']);
    header("location:index.php");
    echo "<script>alert('file deleted successfully');</script>";
}
else
{
    unlink("./upload/".$_GET['delete_file']);
    header("location:index.php");
    echo "<script>alert('file deleted successfully');</script>";
}
?>