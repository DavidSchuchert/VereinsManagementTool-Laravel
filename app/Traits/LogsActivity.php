<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getRecordEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    protected function logActivity(string $event)
    {
        $changes = null;
        if ($event === 'updated') {
            $changes = [
                'before' => array_intersect_key($this->getOriginal(), $this->getDirty()),
                'after' => $this->getDirty(),
            ];
            
            // Remove sensitive fields
            unset($changes['before']['password'], $changes['after']['password']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $event,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
