<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve form data
$Train_Name = $_POST['train_name'];
$Departure_Date = $_POST['departure_date'];
$Departure_Time = $_POST['departure_time'];
$Seat_Number = $_POST['seat_number'];
$Passenger_Name = $_POST['passenger_name'];

try {
    // XAMPP MySQL connection parameters
    $dsn = "mysql:host=localhost;dbname=train;charset=utf8mb4";
    $username = "root";
    $password = ""; // Default password is empty

    // Create PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if any field is empty
    if (!empty($Train_Name) && !empty($Departure_Date) && !empty($Departure_Time) && !empty($Seat_Number) && !empty($Passenger_Name)) {
        
        // Prepare select statement
        $stmt = $pdo->prepare("SELECT seat_number FROM train WHERE seat_number = ? LIMIT 1");
        $stmt->execute([$Seat_Number]);
        $rnum = $stmt->rowCount();

        // Check if seat number is available
        if ($rnum == 0) {
            $stmt = $pdo->prepare("INSERT INTO train (train_name, departure_date, departure_time, seat_number, passenger_name) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$Train_Name, $Departure_Date, $Departure_Time, $Seat_Number, $Passenger_Name]);
            echo "New record inserted successfully";
            header('Location: update_Delete.html');
            exit(); // Ensure to call exit after header redirect
        } else {
            echo "Someone already booked this seat";
        }
    } else {
        echo "All fields are required";
        die();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
