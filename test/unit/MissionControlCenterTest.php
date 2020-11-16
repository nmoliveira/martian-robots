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

    public function test_input() {
        $input = __DIR__ . "/robot-instructions.txt";

        $missionControlCenter = new MissionControlCenter();
        $missionControlCenter->loadInstructions($input);
        $missionControlCenter->createMap();
        $missionControlCenter->createRobots();
        $missionControlCenter->deployRobots();
        $report = $missionControlCenter->report();

        $this->assertEquals($report, "1 1 E\n3 3 N LOST\n2 3 S\n");
    }

}