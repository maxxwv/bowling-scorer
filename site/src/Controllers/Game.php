<?php
namespace Maxxd\Bowling\Controllers;

use ArrayObject;
use \Maxxd\Bowling\Controllers\Frame;

class Game{

	public function __construct(
		private $frames = new ArrayObject(),
	)
	{
		$this->frames->append(new Frame());
		return $this;
	}

	public function roll($score) : self
	{
		$crFrame = count($this->frames) - 1;

		$this->frames->offsetGet($crFrame)->throw($score);
		$this->frames->offsetGet($crFrame)->markStrike();
		$this->frames->offsetGet($crFrame)->markSpare();

		if($this->frames->offsetGet($crFrame)->closedOut()){
			$this->frames->append(new Frame());
		}else{
			$this->frames->offsetGet($crFrame)->nextThrow();
		}
		return $this;
	}

	public function score() : int
	{
		$total = 0;
		foreach($this->frames as $idx => $frame){

			if($frame->isStrike()){
				$total += array_sum($this->frames[($idx + 1)]->getScore());
			}

			if($frame->isSpare()){
				if($frame->getThrow() == 0){
					$total += $frame->getScore()[1];
				}else{
					$total += $this->frames[($idx + 1)]->getScore()[0] ?? 0;
				}
			}

			$total += array_sum($frame->getScore());
		}

		return $total;
	}

	private function getFrame() : int
	{
		return count($this->frames);
	}
}