<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

class CekOngkir 
{
    private $key = '5e2f5d5feaa93fb2b59910584ea38967';
    private $url = 'https://api.rajaongkir.com/starter/';

    private static $instance = null;

    public static function getInstance()
    {

        if(self::$instance == null){
            self::$instance = new CekOngkir;
        }

        return self::$instance;
    }

    public function getProvinsi($provinsiId = null)
    {
        if($provinsiId){

            $response = Http::withHeaders([
                'key' => $this->key,            
            ])->get($this->url."/province",[
                'id' => $provinsiId,                
            ]);

        } else {
            $response = Http::withHeaders([
                'key' => $this->key,            
            ])->get($this->url."/province");
            
        }        

        return $response->object();
    }

    public function getCity($provinsiId, $cityiId = null)
    {
        if($provinsiId AND $cityiId){

            $response = Http::withHeaders([
                'key' => $this->key,            
            ])->get($this->url."/city",[
                'id' => $cityiId, 
                'province' => $provinsiId               
            ]);

        } else if($provinsiId AND !$cityiId) {

            $response = Http::withHeaders([
                'key' => $this->key,            
            ])->get($this->url."/city", [
                'province' => $provinsiId
            ]);
            
        } else if(!$provinsiId AND $cityiId) {

            $response = Http::withHeaders([
                'key' => $this->key,            
            ])->get($this->url."/city", [
                'id' => $cityiId
            ]);
            
        }         

        return $response->object();
    }

    public function getBiaya($origin, $destination, $weight, $courier)
    {        

        $response = Http::withHeaders([
            'key' => $this->key,            
        ])->post($this->url."/cost",[
            'origin' => $origin,                
            'destination' => $destination,                
            'weight' => $weight,                
            'courier' => $courier,                
        ]);
         
        return $response->object();
    }

}