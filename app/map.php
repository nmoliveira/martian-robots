<?php

class Map {
    
    /**
     * @var int Map width
     */
    public $width;

    /**
     * @var int Map height
     */
    public $height;

    /**
     * Scents will be saved in this array
     * Associative array for faster reads!
     * The array key will be 4 characters being the first 2 characters for Coordinate X and 2 other characters for Coordinate Y
     * @var array Array containing the scents left by lost robots
     */
    public $scents = [];

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height) {            
        $this->width = $width;
        $this->height = $height; 
    }

    /**
     * Generate key for the array
     * 
     * @param int $x Coordinate x
     * @param int $y Coordinate y
     * @return string Key
     */ 
    private function getKey($x, $y) {
        // if coordinates are less than 10 (meaning just 1 character) add '0' as first character concatenated with coordinate
        if ($x < 10) $x = "0{$x}";
        if ($y < 10) $y = "0{$y}";
        return $x . $y;
    }

    /**
     * Add scent to given position
     * 
     * @param int $x Coordinate x
     * @param int $y Coordinate y
     */ 
    public function addScent(int $x, int $y){
        $key = $this->getKey($x, $y);
        $this->scents[$key] = true;
    }

    /**
     * Check if there is a scent for the given position
     * @param int $x Coordinate x
     * @param int $y Coordinate y
     * @return boolean true if there is false otherwise
     */
    public function isThereScentLeft(int $x, int $y) {
        $key = $this->getKey($x,$y);
        return $this->scents[$key];
    }
}