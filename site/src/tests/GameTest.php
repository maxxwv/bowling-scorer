<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use \Maxxd\Bowling\Controllers\Game;

/**
 * Run `./vendor/phpunit/phpunit/phpunit ./src/tests/GameTest.php --testdox`
 * Results can be verified here: https://www.bowlinggenius.com/
 */
class GameTest extends TestCase{
	public function setUp() : void
	{
		$this->game = new Game();
	}
	public function testStraightFrames()
	{
		$this->assertEquals(
			9,
			$this->game
				->roll(5)
				->roll(4)
				->score()
		);
	}
	public function testStrikes()
	{
		$this->assertEquals(
			25,
			$this->game
				->roll(1)
				->roll(4)

				->roll(10)

				->roll(3)
				->roll(2)

				->score()
		);
	}
	public function testSpares()
	{
		$this->assertEquals(
			30,
			$this->game
				->roll(7)
				->roll(2)

				->roll(3)
				->roll(7)

				->roll(5)
				->roll(1)

				->score()
		);
	}
	public function testZeroSpares()
	{
		$this->assertEquals(
			54,
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

				->score()
		);
	}
	public function testFullGame()
	{
		$this->assertEquals(
			116,
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

				->roll(10)

				->roll(8)
				->roll(1)

				->roll(4)
				->roll(2)

				->roll(5)
				->roll(3)

				->roll(10)
				->roll(5)
				->roll(5)

				->score()
		);
	}
	public function testTurkey()
	{
		$this->assertEquals(
			91,
			$this->game
				->roll(4)
				->roll(3)

				->roll(10)

				->roll(10)

				->roll(10)

				->roll(6)
				->roll(3)

				->score()
		);
	}
	public function testPerfectGame()
	{
		$this->assertEquals(
			300,
			$this->game
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->roll(10)
				->score()
		);
	}
	public function testNotPossible()
	{
		try{
			$this->game
				->roll(6)
				->roll(9)
				->score();
		}catch(Exception $e){
			$this->assertEquals(
				'Really, dude?',
				$e->getMessage()
			);
		}
	}
}