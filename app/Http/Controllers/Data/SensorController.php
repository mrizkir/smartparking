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
		$sensor = \DB::table('sensor AS A')
		->select(\DB::raw('
			A.id,
			A.sensor_id,
			A.label,
			A.status,
			A.created_at,
			A.updated_at
		'))		 
		->orderBy('created_at', 'desc')
		->get();

		return Response()->json([
			'status'=>'000',
			'pid'=>'index',
			'data'=>$sensor,    
			'message'=>"data sensor berhasil berhasil diperoleh",    
		], 200); 
	}
	public function latest(Request $request, $id)
	{
		$sensor = \DB::table('sensor AS A')
		->select(\DB::raw('
			A.id,
			A.sensor_id,
			A.label,
			A.status,
			A.created_at,
			A.updated_at
		'))
		->where('sensor_id', $id)
		->limit(1)
		->orderBy('created_at', 'desc')
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
			'status'=>'required|in:0,1,2',			
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