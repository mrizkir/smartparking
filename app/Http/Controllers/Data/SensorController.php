<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\Data\SensorModel;

class SensorController extends Controller
{
  public function show(Request $request, $id) {
    
  }
  /**
	 * digunakan untuk menyimpan data sensor
	 */
	public function store(Request $request)
	{
    $request->validate([
			'sensor_id'=>'required|numeric',			
			'label'=>'required',			
			'status'=>'required|in:0,1',			
		]);
		
		$sensor_id = $request->input('sensor_id');
		$sensor = \DB::create([
			'id'=>Uuid::uuid4()->toString(),
			'sensor_id' => $sensor_id,
			'label' => "slot-$sensor",
			'status' => $request->input('status')
		]);
		
		return Response()->json([
			'status'=>1,
			'pid'=>'store',
			'sensor'=>$sensor,    
			'message'=>"data sensor berhasil berhasil disimpan",    
		], 200); 
  }
}