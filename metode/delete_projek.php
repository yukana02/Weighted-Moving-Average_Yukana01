<?php

    include('../connection.php');
    session_start(); 
    if($user = $_SESSION['userr']){
        $_SESSION['forcast_har'] = $_GET['FORCAST_HAR'];
        $id = $_SESSION['forcast_har'];
        $select = mysqli_query ($conn, "SELECT * FROM harian WHERE FORCAST_HAR = '$id'");
        $row = mysqli_fetch_array($select);
        $tanda = $row['ID_HAR'];
        if($select){
            $delete_hasil = mysqli_query  ($conn, "DELETE FROM HASIL WHERE ID_HAR = '$id'");
            if($delete_hasil){
                $delete_data = mysqli_query ($conn , "DELETE FROM HARIAN  WHERE FORCAST_HAR = '$id'");
                if($delete_data){
                    echo "<script>alert('DATA BERHASIL DI HAPUSS');</script>";
                    echo header('Location:pendapatan.php');
                    
                }
                else{
                    echo "<script>alert('DATA GAGAL DI HAPUS');</script>";
            
                    echo header('Location:pendapatan.php');
                }
            }
        }
    }
    
    
?>