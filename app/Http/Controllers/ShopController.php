<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RakutenRws_Client;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        
        
        $client = new RakutenRws_Client();

        define("RAKUTEN_APPLICATION_ID", config('app.rakuten_id'));

        $client->setApplicationId(RAKUTEN_APPLICATION_ID);
        
        $items = [];
        for ($i = 1; $i < 4; $i++) {
            $response = $client->execute('IchibaItemRanking',array(
                'page' => $i,
                'imageFlag' => 1,
                'period' => 'realtime'
            ));
            
            
            if(!$response->isOk()){
                return 'Error:'.$response->getMessage();
            } else {
                // $items = [];
                // foreach($response as $key => $rakutenItem){
                //     $items[$key]['title'] = $rakutenItem['itemName'];
                //     $items[$key]['price'] = $rakutenItem['itemPrice'];
                //     $items[$key]['url'] = $rakutenItem['itemUrl'];
                    
                //     if($rakutenItem['imageFlag']){
                //         $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
                //         $items[$key]['img'] = preg_replace('/^http:/','https:',$imgSrc);
                //     }
                // }
                
                foreach ($response as $item_info) {
                    $item['title'] = $item_info['itemName'];
                    $item['price'] = $item_info['itemPrice'];
                    $item['url'] = $item_info['itemUrl'];
                    $item['img'] = $item_info['mediumImageUrls'][0]['imageUrl'];
                    array_push($items, $item);
                }
            }
        }
        
        $items_list = ['items' => $items];
        return redirect()->route('shops.show')->withInput($items_list);
    }
    
    public function search(Request $request)
    {
        $client = new RakutenRws_Client();

        define("RAKUTEN_APPLICATION_ID", config('app.rakuten_id'));

        $client->setApplicationId(RAKUTEN_APPLICATION_ID);
        
        $keyword = $request->input('keyword');
        $genreId = $request->input('genre');
        
        
        if (isset($keyword) || isset($genreId)) {
            $items = [];
            for ($i = 1; $i < 4; $i++) {
                $response = $client->execute('IchibaItemSearch',array(
                    'keyword' => $keyword,
                    'genreId' => $genreId,
                    'page' => $i,
                    'imageFlag' => 1
                ));
                
                if(!$response->isOk()){
                    return 'Error:'.$response->getMessage();
                } else {
                    // $items = [];
                    // foreach($response as $key => $rakutenItem){
                    //     $items[$key]['title'] = $rakutenItem['itemName'];
                    //     $items[$key]['price'] = $rakutenItem['itemPrice'];
                    //     $items[$key]['url'] = $rakutenItem['itemUrl'];
        
                    //     if($rakutenItem['imageFlag']){
                    //         $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
                    //         $items[$key]['img'] = preg_replace('/^http:/','https:',$imgSrc);
                    //     }
                    // }
                    
                    foreach ($response as $item_info) {
                        $item['title'] = $item_info['itemName'];
                        $item['price'] = $item_info['itemPrice'];
                        $item['url'] = $item_info['itemUrl'];
                        $item['img'] = $item_info['mediumImageUrls'][0]['imageUrl'];
                        array_push($items, $item);
                    }
                }    
            }
            
            $items_list = ['items' => $items];
            return redirect()->route('shops.show')->withInput($items_list);
        } else {
            return redirect()->route('shops.index');
        }
    }
    
    public function show(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $items = old('items');
        if (isset($items)) {
            return view('shops.shop', compact('items', 'user'));    
        } else {
            return redirect()->route('shops.index');
        }
        
    }
}
