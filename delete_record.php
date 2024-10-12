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

$Seat_Number = $_POST['seat_number'];  // Identifier for deleting

if (isset($Seat_Number)) {  // Check if the seat number is provided
    // Check if the record exists
    $Select = "SELECT * FROM train WHERE seat_number = ? LIMIT 1";
    $stmt = $conn->prepare($Select);  // Initialize $stmt here
    $stmt->bind_param("s", $Seat_Number);
    $stmt->execute();
    $stmt->store_result();  // Ensure this line is correct

    if ($stmt->num_rows > 0) {  // If the record exists, proceed with deletion
        $Delete = "DELETE FROM train WHERE seat_number = ?";
        $stmt->close();  // Close the select statement
        $stmt = $conn->prepare($Delete);  // Re-initialize $stmt
        $stmt->bind_param("s", $Seat_Number);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {  // If delete was successful
            echo "Record deleted successfully";
        } else {
            echo "Deletion failed";  // If no rows were affected
        }
    } else {
        echo "Record not found for deleting";  // No matching record
    }
} else {
    echo "Seat Number not provided";  // In case the form doesn't provide this
}

$stmt->close();  // Closing the prepared statement
$conn->close();  // Closing the database connection
?>
