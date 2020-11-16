<?php

require __DIR__ . "/app/mission-control-center.php";
$input = __DIR__ . "/robot-instructions.txt";

$missionControlCenter = new MissionControlCenter();
$missionControlCenter->loadInstructions($input);
$missionControlCenter->createMap();
$missionControlCenter->createRobots();
$missionControlCenter->deployRobots();
echo $missionControlCenter->report();