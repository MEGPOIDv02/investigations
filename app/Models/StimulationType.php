<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StimulationType
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|Investigation[] $investigations
 *
 * @package App\Models
 */
class StimulationType extends Model
{
	protected $table = 'stimulation_type';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function investigations()
	{
		return $this->hasMany(Investigation::class, 'fk_id_inv_stimulation_type');
	}

    public static function getAll()
    {
        return self::select('id', 'name')->get();
    }
}
