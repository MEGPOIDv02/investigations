<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Investigation
 *
 * @property int $id
 * @property string $name
 * @property string $effects
 * @property string $duration
 * @property string $frecuenty
 * @property string $intensity
 * @property string $time
 * @property string $colocation
 * @property string $document
 * @property bool $concent
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $fk_id_inv_type
 * @property int $fk_id_inv_stimulation_type
 * @property int $fk_id_inv_sign_type
 *
 * @property SignsType $signs_type
 * @property StimulationType $stimulation_type
 * @property InvType $inv_type
 *
 * @package App\Models
 */
class Investigation extends Model
{

    const ACCELOMETER=1;
    const STIMULATION=2;
    const STABILOMETRY=3;

	protected $table = 'investigations';

	protected $casts = [
		'concent' => 'bool',
		'active' => 'bool',
		'fk_id_inv_type' => 'int',
		'fk_id_inv_stimulation_type' => 'int',
		'fk_id_inv_sign_type' => 'int'
	];

	protected $fillable = [
		'name',
		'effects',
		'duration',
		'frecuenty',
		'intensity',
		'time',
		'colocation',
		'document',
		'concent',
		'active',
		'fk_id_inv_type',
		'fk_id_inv_stimulation_type',
		'fk_id_inv_sign_type'
	];

    protected $appends=[
        "full_date",
    ];

	public function signs_type()
	{
		return $this->belongsTo(SignsType::class, 'fk_id_inv_sign_type');
	}

	public function stimulation_type()
	{
		return $this->belongsTo(StimulationType::class, 'fk_id_inv_stimulation_type');
	}

	public function inv_type()
	{
		return $this->belongsTo(InvType::class, 'fk_id_inv_type');
	}

    public function getFullDateAttribute(){
        return $this->created_at->format('d-m-Y');
    }
}
