<?php 

require "connect.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $sql_delete = mysqli_query($conn, "DELETE FROM furniture WHERE id=$id");
    
    if ($sql_delete){
        echo"<script> alert('Data Ini Berhasil dihapus')</script>";
        echo"<meta http-equiv='refresh' content='0; URL=addCatalog.php'>";
    } else {
        echo"<script> alert('Data Ini gagal dihapus')</script>";
        echo"<meta http-equiv='refresh' content='0; URL=index.php'>";
    }
}
?>