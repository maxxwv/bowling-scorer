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
		if($crFrame == 9){
			$this->frames->offsetGet($crFrame)->setTenthFrame();
		}

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

			if($frame->isStrike() && !$frame->isTenthFrame()){
				$total += array_sum($this->frames[($idx + 1)]->getScore());
				if($this->frames[($idx + 1)]->getThrow() == 0 && $this->frames[($idx + 1)]->closedOut()){
					$total += $this->frames[($idx + 2)]->getScore()[0];
				}
				// there's gotta be a better way
				if($this->frames[($idx + 1)]->isTenthFrame() && count( $this->frames[($idx + 1)]->getScore() ) == 3){
					$total -= $this->frames[($idx + 1)]->getScore()[2];
				}
			}

			if($frame->isSpare() && !$frame->isTenthFrame()){
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