<?php 

include_once 'src/trafficTracker.php';

$tracker = new TrafficTracker();

?>

<a href="example.php">Go to the page itself</a><br>
<a href="https://google.ro">Go to google</a><br>

<?php 

echo '<br><br>Current status of the tracker:<br>';
echo 'Succes is: ' . ($tracker->succes ? 'true' : 'false');
if (!$tracker->succes) {
    echo '<br>Failure reason is: ' . $tracker->error;
}

echo '<br><br>Internal links (json):<br>';
echo json_encode($tracker->getInternalLinks());

echo '<br><br>External links (json):<br>';
echo json_encode($tracker->getExternalLinks());

?>