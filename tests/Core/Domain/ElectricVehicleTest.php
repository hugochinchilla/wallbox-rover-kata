<?php

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use PHPUnit\Framework\TestCase;

class ElectricVehicleTest extends TestCase
{
    private ElectricVehicle $ev;

    public function setUp(): void
    {
        parent::setUp();
        $this->ev = new ElectricVehicle();
    }

    /**
     * @test
     * @dataProvider rotateLeftProvider
     */
    public function an_ev_should_rotate_left(string $command, string $expectedOutput): void
    {
        $result = $this->ev->execute($command);

        $this->assertEquals($expectedOutput, $result);
    }

    public function rotateLeftProvider()
    {
        return [
            "If facing north, will face W after one rotation" => ["L", "0:0:W"],
            "If facing north, will face S after two rotations" => ["LL", "0:0:S"],
            "If facing north, will face E after three rotations" => ["LLL", "0:0:E"],
            "If facing north, will face N after four rotations" => ["LLLL", "0:0:N"],
        ];
    }

    /**
     * @test
     * @dataProvider rotateRightProvider
     */
    public function an_ev_should_rotate_right(string $command, string $expectedOutput): void
    {
        $result = $this->ev->execute($command);

        $this->assertEquals($expectedOutput, $result);
    }

    public function rotateRightProvider()
    {
        return [
            "If facing north, will face E after one rotation" => ["R", "0:0:E"],
            "If facing north, will face S after two rotations" => ["RR", "0:0:S"],
            "If facing north, will face W after three rotations" => ["RRR", "0:0:W"],
            "If facing north, will face N after four rotations" => ["RRRR", "0:0:N"],
        ];
    }

    /** @test */
    public function an_ev_should_move_forward(): void
    {
        $result = $this->ev->execute('M');

        $this->assertEquals('0:1:N', $result);
    }
}
