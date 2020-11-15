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
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height) {
        $this->width = $width;
        $this->height = $height; 
    }
}