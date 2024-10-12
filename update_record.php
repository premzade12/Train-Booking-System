<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "train";

// Establish connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if (mysqli_connect_error()) {
    die('Connection Error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

$Seat_Number = $_POST['seat_number'];  // Identifier
$Train_Name = $_POST['train_name'];
$Departure_Date = $_POST['departure_date'];
$Departure_Time = $_POST['departure_time'];
$Passenger_Name = $_POST['passenger_name'];

// Check if the record exists
$Select = "SELECT * FROM train WHERE seat_number = ? LIMIT 1";
$stmt = $conn->prepare($Select);
$stmt->bind_param("s", $Seat_Number);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {  // If record exists, update it
    $Update = "UPDATE train SET train_name = ?, departure_date = ?, departure_time = ?, passenger_name = ? WHERE seat_number = ?";
    
    $stmt->close();  // Close the select statement
    $stmt = $conn->prepare($Update);
    $stmt->bind_param("sssss", $Train_Name, $Departure_Date, $Departure_Time, $Passenger_Name, $Seat_Number);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {  // Check if update was successful
        echo "Record updated successfully";
    } else {
        echo "Update failed";  // If update didn't affect any rows
    }
} else {
    echo "Record not found for updating";  // No matching record found
}

$stmt->close();
$conn->close();
?>
