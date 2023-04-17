@extends('layouts.master')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add Item</h1>                      
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{url('insert')}}">
                    <div class=" mb-3">
                        <label for="item_name">Item name</label>
                        <input class="form-control" id="item_name" name="item_name" type="text" placeholder="Item name" required/>
                    </div>
                    <div class=" mb-3">
                        <label for="item_category">Item Category</label>
                        <input class="form-control" id="item_category" name="item_category" type="text" placeholder="Item Category" required/>
                    </div>
                    <div class=" mb-3">
                        <label for="item_mrp">MRP</label>
                        <input class="form-control" step="0.01" id="item_mrp" name="item_mrp" type="number" placeholder="MRP" required/>
                    </div>
                    <div class=" mb-3">
                        <label for="item_image">Item Photo <small>(only jpg & png allowed)</small></label>
                        <input class="form-control" id="item_image" name="item_image" type="file" placeholder="Item Photo" required accept="image/png, image/jpeg"/>
                    </div>
                    @csrf
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-1">
                        <button class="btn btn-primary">Add</button>
                    </div>
                    @if(session()->has('msg'))
                    <?php echo session('msg'); ?>
                    @endif
                    @endsection
                </form>
            </div>
        </div>
    </div>
</main>
