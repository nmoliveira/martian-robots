<?php

/**
 * Class Robot
 */
class Robot {
    
    const ROTATE_LEFT = "L";
    const ROTATE_RIGHT = "R";
    const MOVE_FORWARD = "F";
    const NORTH = "N";
    const SOUTH = "S";
    const EAST = "E";
    const WEST = "W";

    /**
     * Coordinate X
     * @var int
     */
    public $x;
    
    /**
     * Coordinate Y
     * @var int
     */
    public $y;
    
    /**
     * Orientation N, S, E, W for north, south, east, and west
     * @var string 
     */
    public $orientation;
    
    /**
     * $instructions “L”, “R”, and “F” for rotate left, rotate right, move forward
     * @var string
     */
    private $instructions;
    
    /**
     * Lost status
     * @var boolean
     */
    public $lost;

    /**
     * The map for the navigation in the terrain
     * @var Map
     */
    private $map;

    /**
     * @param int $x Coordinate X
     * @param int $y Coordinate Y
     * @param string $orientation N, S, E, W for north, south, east, and west
     * @param string $instructions “L”, “R”, and “F” for rotate left, rotate right, move forward
     * @param Map $map
     */
    public function __construct(int $x, int $y, string $orientation, string $instructions, Map $map) {

        if ($x < 0 || $x >50) throw new \Exception ("Invalid X");
        if ($y < 0 || $y >50) throw new \Exception ("Invalid Y");

        // test if instruction has only 'L', 'R' or 'F' characters
        preg_match('/^[L|R|F]*$/', $instructions, $outputArray);

        if (empty($outputArray) || strlen($this->instructions)>100) throw new \Exception ("Invalid set of instructions");

        $this->x = $x;
        $this->y = $y;
        $this->orientation = $orientation;
        $this->instructions = $instructions;
        $this->lost = false;
        $this->map = $map;
    }

    /**
     * Execute instructions
     * Split the instructions string into each command and execute it
     */
    public function executeInstructions() {
    
        $commandsArray = str_split($this->instructions);

        foreach($commandsArray as $command) {
            if ($this->lost) break;
            $this->executeCommand($command);
        }
    }

    /**
     * Update robot position based on the received command
     * 
     * @param string $command
     */
    private function executeCommand(string $command) {

        switch ($command) {
            case self::ROTATE_LEFT: 
                $this->orientation = $this->rotateLeft($this->orientation);
                break;
            case self::ROTATE_RIGHT:
                $this->orientation = $this->rotateRight($this->orientation);
                break;
            case self::MOVE_FORWARD:
                $newCoordinates = $this->moveForward($this->x, $this->y, $this->orientation);

                // if new coordinates are inside the grid then update Robot position
                $insideGridConditions = $newCoordinates["x"] >= 0 && $newCoordinates["y"] >= 0 
                    && $newCoordinates["x"] <= $this->map->width && $newCoordinates["y"] <= $this->map->height;

                if ($insideGridConditions) {
                    $this->x = $newCoordinates["x"];
                    $this->y = $newCoordinates["y"];
                } else {
                    // new coordinates are out of grid
                    // check if there is a scent on current position so the robot can ignore the command
                    $scentExists = $this->map->isThereScentLeft($this->x, $this->y);
                    if (!$scentExists) {
                        // robot needs to follow command
                        $this->lost = true;
                        $this->map->addScent($this->x, $this->y);
                    }
                }

                break;
        }
    }

    /**
     * Rotate left
     * @param string $orientation
     * @return string new orientation
     */
    public function rotateLeft(string $orientation) {
        switch ($orientation) {
            case self::NORTH:
                return self::WEST;
                break;
            case self::WEST:
                return self::SOUTH;
            case self::SOUTH:
                return self::EAST;
                break;
            case self::EAST:
                return self::NORTH;
                break;
        }
    }

    /**
     * Rotate right
     * @param string $orientation
     * @return string new orientation
     */
    public function rotateRight(string $orientation) {
        switch ($orientation) {
            case self::NORTH:
                return self::EAST;
                break;
            case self::EAST:
                return self::SOUTH;
            case self::SOUTH:
                return self::WEST;
                break;
            case self::WEST:
                return self::NORTH;
                break;
        }
    }

    /**
     * Move forward
     * @param int $x Position x
     * @param int $y Position y
     * @param string $orientation
     * @return string array Associative array containing keys 'x' and 'y' for the coordinates
     */
    public function moveForward(int $x, int $y, string $orientation) {
        switch ($orientation) {
            case self::NORTH: $y++; break;
            case self::EAST: $x++; break;
            case self::SOUTH: $y--; break;
            case self::WEST: $x--; break;
        }
        $coordinates["x"] = $x;
        $coordinates["y"] = $y;
        return $coordinates;
    }
}