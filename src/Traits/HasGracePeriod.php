<?php


namespace Koverae\KoveraeBilling\Traits;


use Koverae\KoveraeBilling\Helpers\CarbonHelper;
use Koverae\KoveraeBilling\Services\Period;

trait HasGracePeriod
{
    /**
     * Grace total duration in specified interval
     * @param string $interval
     * @return int
     * @throws \Exception
     */
    public function getGraceTotalDurationIn(string $interval) :int
    {
        $gracePeriod = new Period($this->grace_interval, $this->grace_period);
        return $gracePeriod->getStartDate()->{CarbonHelper::diffIn($interval)}($gracePeriod->getEndDate());
    }

    /**
     * Check if entity has grace.
     *
     * @return bool
     */
    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }
}
