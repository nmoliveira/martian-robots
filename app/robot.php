<?php

/**
 * Class Robot
 */
class Robot {
    
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
            // execute command
        }
    }
}