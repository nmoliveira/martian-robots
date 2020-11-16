<?php

require __DIR__ . "/map.php";
require __DIR__ . "/robot.php";

/**
 * This is the mission control center
 * It is responsible for deploying the robots in the terrain
 */
class MissionControlCenter {
    /**
     * Array with upper right coordinate at index 0 and robot instructions in the other positions
     * @var array
     */
    public $instructions = [];
    
    /**
     * constructor
     */
    public function __construct() {
    }

    /**
     * The map
     * @var Map
     */
    private $map;

    /**
     * The robots
     * @var Robot array
     */
    public $robots = [];

    /**
     * Load content from the file with data about the grid and instructions
     * Create an array entry for each line -- discard empty lines
     * 
     * @param string $input
     */
    public function loadInstructions(string $input) {
        if (!(file_exists($input))) {
            throw new \Exception('File does not exist');
        }

        $lines = explode(PHP_EOL, file_get_contents($input));
        
        foreach($lines as $line) {

            if ($line == "") continue;
            array_push($this->instructions,$line); 
        }
    }

    /**
     * Create map
     */
    public function createMap() {
        $dimensions = explode(" ", $this->instructions[0]);
        $this->map = new Map($dimensions[0], $dimensions[1]);
    }

    /**
     * Create robots
     */
    public function createRobots() {
        for ($i=1; $i < count($this->instructions); $i++) { 
          
            $instruction = explode(" ", $this->instructions[$i]);
 
            $robot = new Robot($instruction[0], $instruction[1], $instruction[2], strtoupper($instruction[3]), $this->map);
            array_push($this->robots, $robot);
        }
    }

    /**
     * Make all robots follow their instructions
     */
    public function deployRobots() {
        foreach($this->robots as $robot) {
            $robot->executeInstructions();
        }
    }

    /**
     * Output report for all the robots
     * @return string report
     */
    public function report(){
        $report = "";
        foreach ($this->robots as $robot) {
            if ($robot->lost) $report = $report . "{$robot->x} {$robot->y} {$robot->orientation} LOST\n";
            else $report = $report . "{$robot->x} {$robot->y} {$robot->orientation}\n";
        }
        return $report;
    }
}