<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Api;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    function __construct(){
        $this->host = (new Api())->getHost();
        $this->noData = (new Api())->getNoData();
    }
    
    public function index(){
        $resource = 'intensity';
        $response = Http::get($this->host.$resource);
        if ( !$response->failed() ){
            $data = json_decode($response->body());
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }
        
        //dd($data);
        return view('intensity', compact('data'));
    }

    public function today(){
        $resource = 'intensity/date';
        $response = Http::get($this->host.$resource);
        if ( !$response->failed() ){
            $data = json_decode($response->body());
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }
        
        //dd($data);
        return view('today', compact('data'));
    }

    public function date(){
        $resource = 'intensity/date/' . Carbon::create(2020, rand(1, 12), rand(1, 31))->format('Y-m-d');
        $response = Http::get($this->host.$resource);
        if ( !$response->failed() ){
            $data = json_decode($response->body());
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }

        //dd($data);
        return view('date', compact('data'));
    }

    public function factors(){
        $resource = 'intensity/factors';
        $response = Http::get($this->host.$resource);
        if ( !$response->failed() ){
            $data = json_decode($response->body());
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }
        
        //dd($data);
        return view('factors', compact('data'));
    }

    //more
    public function more(){
        return view('more');
    }

    //ajax
    public function filtering(Request $request){
        
        $validated = $request->validate([
            'region'     => 'required|int|min:1'
        ]);

        $resource = 'regional/regionid/' . $request->input('region');
        $response = Http::get($this->host.$resource);
        if ( !$response->failed() ){
            $data = json_decode($response->body());
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }
        
        //dd($data);

        return response()->json($data);
    }

    public function average(Request $request){
        
        $validated = $request->validate([
            'region'     => 'required|int|min:1',
            'date-start' => 'required|date_format:Y-m-d',
            'date-end'   => 'required|date_format:Y-m-d',
            'metric'     => 'required|string'
        ]);
         
        $start_date = Carbon::create($request->input('date-start'));
        $end_date   = Carbon::create($request->input('date-end'));
        $resource = 'regional/intensity/'.$start_date->toIso8601String().'/'.$end_date->toIso8601String().'/regionid/' . $request->input('region');
        $response = Http::get($this->host.$resource);
        
        if ( !$response->failed() ){
            $data = json_decode($response->body());

            $total = 0;
            $metrics = $data->data->data;
            
            foreach($metrics as $metric){
                foreach($metric->generationmix as $value){
                    if ( $value->fuel == $request->input('metric') ){
                        $total += $value->perc;
                    }
                }
            }
            
            $data = array('string' => 'The Total is ' . $total . ' and the Average is ' . $total / $start_date->diffInDays($end_date) .'/day' );
        }else{
            $data = ['success' => false, 'msg' => $this->noData];
        }

        //dd($data);
        return response()->json($data);
    }


}
