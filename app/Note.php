<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Note
 * @package App
 *
 * @property int $id
 * @property int $entity_id
 * @property int $entity_type
 * @property string $message
 * @property int|null $user_id
 * @property DateTime|null $created_at
 * @property DateTime|null $updated_at
 * @property DateTime|null $deleted_at
 *
 */
class Note extends Model
{
    const TYPE_HELP_REQUEST = '1';
    const TYPE_HELP_RESPONSE = '2';

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
