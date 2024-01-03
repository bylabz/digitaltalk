<?php

namespace Tests\Unit;

use DTApi\Helpers\TeHelper;
use PHPUnit\Framework\TestCase;

class TeHelperTest extends TestCase
{
    public function testWillExpireAt()
    {
        $dateDuetime   = '2024-01-07';
        $dateCreatedAt = '2024-01-03';

        $dueTime   = Carbon::parse($dateDuetime);
        $createdAt = Carbon::parse($dateCreatedAt);
        $difference = $dueTime->diffInHours($createdAt);

        if ($difference <= 90)
            $time = $dueTime;
        elseif ($difference <= 24) {
            $time = $createdAt->addMinutes(90);
        } elseif ($difference > 24 && $difference <= 72) {
            $time = $createdAt->addHours(16);
        } else {
            $time = $dueTime->subHours(48);
        }

        $helper = new TeHelper();
        $this->assertEquals($time->format('Y-m-d H:i:s'), $helper->willExpireAt($dateDuetime, $dateCreatedAt));
    }
}
