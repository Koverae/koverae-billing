<?php


namespace Koverae\KoveraeBilling\Traits;


use Koverae\KoveraeBilling\Helpers\CarbonHelper;
use Koverae\KoveraeBilling\Services\Period;
use Carbon\Carbon;

trait HasTrialPeriod
{
    /**
     * Trial total duration in specified interval
     * @param string $interval
     * @return int
     * @throws \Exception
     */
    public function getTrialTotalDurationIn(string $interval) :int
    {
        $trialPeriod = new Period($this->trial_interval, $this->trial_period);
        return $trialPeriod->getStartDate()->{CarbonHelper::diffIn($interval)}($trialPeriod->getEndDate());
    }

    /**
     * Check if entity has trial.
     *
     * @return bool
     */
    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }
}
