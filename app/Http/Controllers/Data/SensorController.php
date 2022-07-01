<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\Data\SensorModel;

class SensorController extends Controller
{
	public function index(Request $request)
	{
		$sub_query = \DB::table('sensor')
		->select(\DB::raw('
			id,
			MAX(created_at) AS created_at
		'))
		->groupBy('sensor_id');

		$sensor = \DB::table('sensor AS A')
		->select(\DB::raw('
			A.id,
			A.sensor_id,
			A.label,
			A.status,
			A.created_at,
			A.updated_at
		'))
		->joinSub($sub_query, 'B', function($join){
			$join->on('A.id','=','B.id');			
		}) 
		->orderBy('sensor_id', 'asc')
		->get();

		return Response()->json([
			'status'=>'000',
			'pid'=>'index',
			'data'=>$sensor,    
			'message'=>"data sensor berhasil berhasil diperoleh",    
		], 200); 
	}
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
		
		$sensor = SensorModel::create([
			'id'=>Uuid::uuid4()->toString(),
			'sensor_id' => $sensor_id,
			'label' => "slot-$sensor_id",
			'status' => $request->input('status')
		]);
		
		return Response()->json([
			'status'=>'000',
			'pid'=>'store',
			'data'=>$sensor,    
			'message'=>"data sensor berhasil berhasil disimpan",    
		], 200); 
  }
}