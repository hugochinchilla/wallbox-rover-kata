<?php

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;
use PHPUnit\Framework\TestCase;

class ElectricVehicleTest extends TestCase
{
    private ElectricVehicle $ev;

    public function setUp(): void
    {
        parent::setUp();
        $this->ev = new ElectricVehicle(new Surface(10, 10), new Point(0, 0), 'N');
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

    /**
     * @test
     * @dataProvider moveForwardProvider
     */
    public function an_ev_should_move_forward(string $command, string $expectedResult): void
    {
        $result = $this->ev->execute($command);

        $this->assertEquals($expectedResult, $result);
    }

    public function moveForwardProvider()
    {
        return [
            'Can move facing N' => ['M', '0:1:N'],
            'Can move facing W' => ['LM', '-1:0:W'],
            'Can move facing S' => ['LLM', '0:-1:S'],
            'Can move facing E' => ['RM', '1:0:E'],
        ];
    }

    /** @test */
    public function an_ev_can_start_at_any_point(): void
    {
        $ev = new ElectricVehicle(new Surface(10, 10), new Point(1, 1), 'N');

        $result = $ev->execute('M');

        $this->assertEquals($result, '1:2:N');
    }

    /** @test */
    public function an_ev_can_start_facing_anywhere(): void
    {
        $ev = new ElectricVehicle(new Surface(10, 10), new Point(0, 0), 'E');

        $result = $ev->execute('M');

        $this->assertEquals($result, '1:0:E');
    }
}
