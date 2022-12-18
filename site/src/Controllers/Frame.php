<?php
namespace Maxxd\Bowling\Controllers;

use Exception;

class Frame{
	public function __construct(
		private int $roll = 0,
		private bool $tenthFrame = false,
		private bool $strike = false,
		private bool $spare = false,
		private array $score = [],
		private bool $closedOut = false,
	){}

	public function getScore() : array
	{
		return $this->score;
	}

	public function nextThrow() : void
	{
		$this->roll++;
	}

	public function throw($pins) : void
	{
		array_push($this->score, $pins);
		$this->setClosedOut(!$this->tenthFrame && $this->roll > 0);
		if(array_sum($this->score) > 10 && !$this->tenthFrame){
			throw new Exception('Really, dude?');
		}
	}

	public function getThrow() : int
	{
		return $this->roll;
	}

	public function closedOut() : bool
	{
		return $this->closedOut;
	}

	public function setClosedOut($set = false) : void
	{
		$this->closedOut = $set;
	}

	public function setTenthFrame() : void
	{
		$this->tenthFrame = true;
	}

	public function isTenthFrame() : bool
	{
		return $this->tenthFrame;
	}

	public function markStrike() : void
	{
		if($this->roll < 1 && array_sum($this->score) == 10){
			$this->strike = true;
			$this->setClosedOut(!$this->tenthFrame);
		}
	}

	public function markSpare() : void
	{
		if(array_sum($this->score) == 10 && !$this->strike && $this->roll > 0){
			$this->spare = true;
		}
	}

	public function isStrike() : bool
	{
		return $this->strike;
	}

	public function isSpare() : bool
	{
		return $this->spare;
	}
}