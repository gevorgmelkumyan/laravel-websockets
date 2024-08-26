<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $path
 * @property string $status
 * @property int $total
 * @property int $generated
 *
 * @property User $user
 */
class File extends Model {
	use HasFactory;

	const STATUS_NEW = 'new';
	const STATUS_GENERATING = 'generating';
	const STATUS_GENERATED = 'generated';
	const STATUS_FAILED = 'failed';

	protected $fillable = [
		'user_id',
		'name',
		'path',
		'status',
		'total',
		'generated',
	];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
}
