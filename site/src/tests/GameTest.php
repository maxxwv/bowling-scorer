<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use \Maxxd\Bowling\Controllers\Game;

/**
 * Run `./vendor/phpunit/phpunit/phpunit ./src/tests/GameTest.php --testdox`
 */
class GameTest extends TestCase{
	public function setUp() : void
	{
		$this->game = new Game();
	}
	public function testStraightFrames()
	{
		$this->assertEquals(
			$this->game
				->roll(5)
				->roll(4)
				->score(),
			9
		);
	}
	public function testStrikes()
	{
		$this->assertEquals(
			$this->game
				->roll(1)
				->roll(4)

				->roll(10)

				->roll(3)
				->roll(2)

				->score(),
			25
		);
	}
	public function testSpares()
	{
		$this->assertEquals(
			$this->game
				->roll(7)
				->roll(2)

				->roll(3)
				->roll(7)

				->roll(5)
				->roll(1)

				->score(),
			30
		);
	}
	public function testZeroSpares()
	{
		$this->assertEquals(
			$this->game
				->roll(2)
				->roll(5)

				->roll(0)
				->roll(10)

				->roll(6)
				->roll(2)

				->roll(7)
				->roll(3)

				->roll(6)
				->roll(1)

				->score(),
				54
		);
	}
}