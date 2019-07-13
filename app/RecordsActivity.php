<?php
/**
 * Created by PhpStorm.
 * User: shisiying
 * Date: 2019-07-12
 * Time: 16:58
 */

namespace App;


trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return ;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event){
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model){
            $model->activity()->delete();
        });

    }

    protected function recordActivity($event)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);
    }

    protected function activity()
    {
        return $this->morphMany('App\Activity','subject');
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

}