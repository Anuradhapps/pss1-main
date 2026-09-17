<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PestAlertNotificationService
{
    /**
     * Only the leadership/admin roles should receive high-risk pest alerts.
     */
    public function notifyIfHighRisk(
        string $pestName,
        int $code,
        string $userId,
        ?string $collectorName = null,
        ?string $phoneNumber = null,
        ?string $location = null
    ): ?Notification {
        if (! in_array($code, [7, 9], true)) {
            return null;
        }

        $receivers = $this->getAlertRecipients($userId);

        if ($receivers->isEmpty()) {
            return null;
        }

        $collectorName = $collectorName ?: 'Unknown collector';
        $phoneNumber = $phoneNumber ?: 'N/A';
        $location = $location ?: 'Unknown location';

        $title = sprintf(
            'Pest risk alert: %s reached code %d for %s | Phone: %s | Location: %s. Immediate action required.',
            $pestName,
            $code,
            $collectorName,
            $phoneNumber,
            $location
        );

        $createdNotification = null;

        foreach ($receivers as $receiver) {
            $createdNotification = Notification::create([
                'id' => Str::uuid(),
                'title' => $title,
                'assigned_to_user_id' => $receiver->id,
                'assigned_from_user_id' => $userId,
                'link' => null,
                'viewed' => false,
            ]);
        }

        return $createdNotification;
    }

    protected function getAlertRecipients(string $userId): Collection
    {
        return User::query()
            ->whereKeyNot($userId)
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'deputyDirector', 'pda', 'extensionAndTrainingDirector']);
            })
            ->distinct()
            ->get();
    }
}
