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

        if (empty($outputArray) || strlen($this->instructions)>100) throw new \Exception ("Invalid set of instructions for");

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
            if (!$this->lost) $this->executeCommand($command);
            else break;
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
                //TODO
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
}