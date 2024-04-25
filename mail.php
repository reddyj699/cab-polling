<?php
include 'connectforrent.php';

// Check if the connection was successful

// Get data from form
$name = $_POST['name'];
$destination = $_POST['destination'];
$email = $_POST['email'];
$contactno = $_POST['contactno'];
$date = $_POST['date'];
$time = $_POST['time'];

// Calculate the time range in PHP
$startRange = date('H:i:s', strtotime($time) - 3600); // One hour before $time
$endRange = date('H:i:s', strtotime($time) + 3600);   // One hour after $time

$sql1 = "SELECT * FROM `booking`
WHERE `da` = '$date'
AND `timing` BETWEEN '$startRange' AND '$endRange'
OR `timing` = '$time'";


$result = $con->query($sql1);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name1 = $row['student'];
        $email1 = $row['email'];
        $date1 = $row['da'];
        $time1 = $row['timing'];
        $destination1 = $row['destination'];
        $contactno1 = $row['contactno'];

        $to = "reddyj699@gmail.com";
        $subject = "Mail From pg booking";
        $txt = "Name->" . $name . "\r\n  Email-> " . $email . "\r\n Date->" . $date . "\r\n Time->" . $time . "\r\n Contact_No->" . $contactno . "\r\n Destination->" . $destination ."\r\n"."\r\n". "\r\n Name->" . $name1 . "\r\n  Email-> " . $email1 . "\r\n Date->" . $date1 . "\r\n Time->" . $time1 . "\r\n Contact_No->" . $contactno1 . "\r\n Destination->" . $destination1;

        // Set headers
        $headers = "From: bookmycab@gmamil.com" . "\r\n" .
            "CC: somebodyelse@example.com";

        // Check if email is not empty before sending
        $delete="DELETE FROM `booking` WHERE student = '$name1'";
        $resultfordelete=$con->query($delete);
        if($resultfordelete){
            echo " hello i delete";
        }
        if (!empty($email)) {
            mail($to, $subject, $txt, $headers);
            

        }
        break;
    }
    echo "Success: Both customers can share a cab for the same date and time slot.";
} else {
    echo "Right now nobody is available as per the record.";
    $sql1 = "INSERT INTO `booking` (student, da, timing, destination, email, contactno)
        VALUES ('$name', '$date', '$time', '$destination', '$email', '$contactno')";
    $result1 = $con->query($sql1);
}
?>
<!-- Your HTML code here -->
