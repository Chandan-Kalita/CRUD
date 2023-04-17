@extends('layouts.master')
@section('content')
<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Item List</h1>                      
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Mrp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Mrp</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $ctr = 1; ?>
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{$ctr}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->category}}</td>
                                            <td>{{$item->mrp}}</td>
                                            <td>
                                                <a href="{{$item->img_path}}" class="btn btn-primary btn-sm" target="_blank">Image</a>
                                                <a href="{{url('edit')}}?id={{$item->item_id}}" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{url('delete')}}?id={{$item->item_id}}" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $ctr++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
@endsection