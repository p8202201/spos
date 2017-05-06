@extends('layouts.admin')
@section('page-header','訂單管理系統')

@section('page-content')

    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>商品</th>
                    <th></th>
                    <th class="text-center"></th>
                    <th class="text-center">小计</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="media-heading">{{$item->product->name}}</h4>
                                </div>
                            </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>${{$item->product->price}}</strong></td>
                        <td class="col-sm-1 col-md-1">
                            <a href="/orders/removeItem/{{$item->id}}"> <button type="button" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> 移除
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h3>總價</h3></td>
                    <td class="text-right"><h3><strong>${{$total}}</strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <a href="{{ url ('orders/new') }}"> <button type="button" class="btn btn-default">
                                繼續新增
                            </button>
                        </a></td>
                    <td>
                        <button type="button" class="btn btn-success">
                            產生訂單 <span class="fa fa-play"></span>
                        </button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection