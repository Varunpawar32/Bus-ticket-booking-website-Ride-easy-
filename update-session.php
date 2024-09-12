<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $seatNumber = $_POST['seatNumber'];

    if ($action === 'add') {
        $_SESSION['selectedSeats'][] = $seatNumber;
    } elseif ($action === 'remove') {
        $index = array_search($seatNumber, $_SESSION['selectedSeats']);
        if ($index !== false) {
            unset($_SESSION['selectedSeats'][$index]);
        }
    }

    // You can add additional logic here if needed
    echo 'Session updated';
}
?>
