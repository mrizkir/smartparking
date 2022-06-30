<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorModel extends Model
{
	use HasFactory;
	
	/**
	 * nama tabel model ini.
	 *
	 * @var string
	*/
	protected $table = 'sensor';
	/**
	 * primary key tabel ini.
	 *
	 * @var string
	*/
	protected $primaryKey = 'id';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	*/
	protected $fillable = [
		'id',		
		'label',					
	];
	/**
	 * enable auto_increment.
	 *
	 * @var string
	*/
	public $incrementing = false;
	/**
	 * activated timestamps.
	 *
	 * @var string
	*/
	public $timestamps = true;
}
