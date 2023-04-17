<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //
    function insert(Request $r){
        $validator = Validator::make($r->all(), [
            'item_name' => 'required|max:150|alpha_num',
            'item_category' => 'required|max:150|alpha_num',
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
            
            session()->flash('msg','
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            Item Inserted Successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            return redirect('/add-new');
        }else{
            $errors = $validator->errors()->all();
            $msg = '<ul>';
            foreach($errors as $error){
                $msg .= "<li>$error</li>";
            }
            $msg .= '</ul>';
            session()->flash('msg','
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            return redirect('/add-new');

        }
    }
    function update(Request $r){
        $validator = Validator::make($r->all(), [
            'item_name' => 'required|max:150|alpha_num',
            'item_category' => 'required|max:150|alpha_num',
            'item_mrp' => 'required|numeric',
            'item_image'=>'mimes:jpg,jpeg,png|max:1024'
        ]);
        extract($r->post());
        if($validator->passes()){
            $item_id = DB::table('item_master')
            ->where('item_id',$item_id)
            ->update([
                'name'=>$item_name,
                'category'=>$item_category,
                'mrp'=>$item_mrp
            ]);
            
            if($r->file('item_image')){
                $ext = $r->file('item_image')->getClientOriginalExtension();
                $r->file('item_image')->storeAs('public/images/item-image/'.$item_id.'.'.$ext);
            }
            
            session()->flash('msg','
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            Item Updated Successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            return redirect('/dashboard');
        }else{
            $errors = $validator->errors()->all();
            $msg = '<ul>';
            foreach($errors as $error){
                $msg .= "<li>$error</li>";
            }
            $msg .= '</ul>';
            session()->flash('msg','
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            return redirect('/edit?id='.$item_id);
            
        }
    }
    function index(Request $r){
        $items = DB::table('item_master')->get();
        foreach($items as $item){
            $images_in_dir = glob('storage/images/item-image/'.$item->item_id.'.{*}', GLOB_BRACE);
            $item->img_path = '';
            if(count($images_in_dir)>0){
                $item->img_path = asset($images_in_dir[0]);
            }
        }
        return view('dashboard')->with('items',$items);
    }
    function delete(Request $r){
        DB::table('item_master')->where('item_id',$r->get('id'))->delete();
        return redirect('/dashboard');
    }
    function edit(Request $r){
        $item = DB::table('item_master')->where('item_id',$r->get('id'))->first();
        if(!$item){
            return redirect('/dashboard');
        }
        return view('edit')->with('item',$item);
    }
}
