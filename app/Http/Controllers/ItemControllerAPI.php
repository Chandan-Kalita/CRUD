<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ItemControllerAPI extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //
    function insert(Request $r){
        $validator = Validator::make($r->all(), [
            'item_name' => 'required|max:150|string',
            'item_category' => 'required|max:150|string',
            'item_mrp' => 'required|numeric',
            'item_image'=>'required|mimes:jpg,jpeg,png|max:1024'
        ]);
        if($validator->passes()){
            extract($r->post());
            $item_id = DB::table('item_master')
                ->insertGetId([
                    'name'=>$item_name,
                    'category'=>$item_category,
                    'mrp'=>$item_mrp
                ]);
            $ext = $r->file('item_image')->getClientOriginalExtension();
            $r->file('item_image')->storeAs('public/images/item-image/'.$item_id.'.'.$ext);
            
            return response()->json(['success'=>'Inserted']);
        }else{
            $errors = $validator->errors()->all();
            return response()->json(['error'=>$errors]);


        }
    }
    function update(Request $r){
        $validator = Validator::make($r->all(), [
            'item_name' => 'required|max:150|string',
            'item_category' => 'required|max:150|string',
            'item_mrp' => 'required|numeric',
            'item_image'=>'mimes:jpg,jpeg,png|max:1024'
        ]);
        extract($r->post());
        if($validator->passes()){
            DB::table('item_master')
            ->where('item_id',$item_id)
            ->update([
                'name'=>$item_name,
                'category'=>$item_category,
                'mrp'=>$item_mrp
            ]);
            
            if($r->file('item_image')){
                $old_pics = glob('storage/images/item-image/'.$item_id.'.{*}', GLOB_BRACE);
                foreach($old_pics as $old_pic){
                    unlink($old_pic);
                }
                $ext = $r->file('item_image')->getClientOriginalExtension();
                $r->file('item_image')->storeAs('public/images/item-image/'.$item_id.'.'.$ext);
            }
            return response()->json(['success'=>'Inserted']);
            
        }else{
            $errors = $validator->errors()->all();
            return response()->json(['error'=>$errors]);
                       
        }
    }
    function list(Request $r){
        $items = DB::table('item_master')->get();
        foreach($items as $item){
            $images_in_dir = glob('storage/images/item-image/'.$item->item_id.'.{*}', GLOB_BRACE);
            $item->img_path = '';
            if(count($images_in_dir)>0){
                $item->img_path = asset($images_in_dir[0]);
            }
        }
        return response()->json(['msg'=>'Item List','data'=>$items]);
    }
    function delete(Request $r){
        DB::table('item_master')->where('item_id',$r->get('id'))->delete();
        return response()->json(['success'=>'Deleted']);
    }
}
