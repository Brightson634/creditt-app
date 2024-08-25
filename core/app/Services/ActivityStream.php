<?php

namespace App\Services;

use App\Models\Activity;

class ActivityStream
{
    /**
     * Logs activity streams in the database
     *
     * @param integer $userId
     * @param string $activity
     * @param string $status
     * @param integer $loan_no
     * @return void
     */
    public static function logActivity(int $userId, string $activity, string $status =null, string $loan_no=null)
    {
        $activityStream = new Activity();
        $activityStream->user_id = $userId;
        $activityStream->activity = $activity;
        $activityStream->status = $status;
        $activityStream->loan_number = $loan_no;
        $activityStream->save();
    }
}
