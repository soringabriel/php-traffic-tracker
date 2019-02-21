-Instalation:

Just add the library in your directory and then run setup.php once. 
However if you run it multiple times it won't cause any damage.

-Usage:

All you need to do is create a new object of the TrafficTracker class 
on each page you want to keep track of. Also don't forget to include the 
TrafficTracker class:

include_once 'src/trafficTracker.php';
$trafficTracker = new TrafficTracker();