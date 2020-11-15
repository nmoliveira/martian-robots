<?php

require __DIR__ . "/../../app/mission-control-center.php";

use PHPUnit\Framework\TestCase;

class MissionControlCenterTest extends TestCase {
 
    /**
     * Test that we can create Mission Control Center
    **/ 
    public function test_can_create_mcc() {
        $mcc = new MissionControlCenter();
        $this->assertNotEmpty($mcc);    
    }

}