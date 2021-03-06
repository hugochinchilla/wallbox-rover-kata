<?php

declare(strict_types = 1);

namespace Example\Tests\Core\Domain;

use Example\App\Core\Domain\ElectricVehicle;
use Example\App\Core\Domain\Heading;
use Example\App\Core\Domain\Point;
use Example\App\Core\Domain\Surface;
use PHPUnit\Framework\TestCase;

class ElectricVehicleTest extends TestCase
{
    private ElectricVehicle $ev;

    public function setUp(): void
    {
        parent::setUp();
        $this->ev = new ElectricVehicle(new Surface(10, 10), new Point(0, 0), Heading::NORTH());
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

    public function rotateLeftProvider(): array
    {
        return [
            'If facing north, will face W after one rotation' => ['L', '0:0:W'],
            'If facing north, will face S after two rotations' => ['LL', '0:0:S'],
            'If facing north, will face E after three rotations' => ['LLL', '0:0:E'],
            'If facing north, will face N after four rotations' => ['LLLL', '0:0:N'],
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

    public function rotateRightProvider(): array
    {
        return [
            'If facing north, will face E after one rotation' => ['R', '0:0:E'],
            'If facing north, will face S after two rotations' => ['RR', '0:0:S'],
            'If facing north, will face W after three rotations' => ['RRR', '0:0:W'],
            'If facing north, will face N after four rotations' => ['RRRR', '0:0:N'],
        ];
    }

    /**
     * @test
     * @dataProvider moveForwardProvider
     */
    public function an_ev_should_move_forward(string $command, string $expectedResult): void
    {
        $ev = new ElectricVehicle(new Surface(10, 10), new Point(5, 5), Heading::NORTH());

        $result = $ev->execute($command);

        $this->assertEquals($expectedResult, $result);
    }

    public function moveForwardProvider(): array
    {
        return [
            'Can move facing N' => ['M', '5:6:N'],
            'Can move facing W' => ['LM', '4:5:W'],
            'Can move facing S' => ['LLM', '5:4:S'],
            'Can move facing E' => ['RM', '6:5:E'],
        ];
    }

    /** @test */
    public function an_ev_can_start_at_any_point(): void
    {
        $ev = new ElectricVehicle(new Surface(10, 10), new Point(1, 1), Heading::NORTH());

        $result = $ev->execute('M');

        $this->assertEquals($result, '1:2:N');
    }

    /** @test */
    public function an_ev_can_start_facing_anywhere(): void
    {
        $ev = new ElectricVehicle(new Surface(10, 10), new Point(0, 0), Heading::EAST());

        $result = $ev->execute('M');

        $this->assertEquals($result, '1:0:E');
    }

    /** @test */
    public function an_ev_can_not_move_to_an_invalid_position(): void
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->ev->execute('LM');
    }
}
