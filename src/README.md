RacerReport
==================================
RacerReport is a PHP class for generating reports on racers and their times.

Usage
==================================
First, create a new instance of the RacerReport class by passing the file paths for the racers and times data:

`$report = new RacerReport('path/to/racers.txt', 'path/to/times.txt');`

You can then generate reports on the racers using the following methods:

`getTopRacers($numRacers = 15)`

Returns an array of the top $numRacers racers, sorted by their best times.

$topRacers = $report->getTopRacers(10);

`getLosersRacers($numRacers = 15)`
Returns an array of the remaining racers after the top $numRacers racers have been removed, sorted by their best times. 

$losersRacers = $report->getLosersRacers(10);

`getRacerByName($name)`
Returns an array representing the racer with the specified name.

$racer = $report->getRacerByName('John Doe');



