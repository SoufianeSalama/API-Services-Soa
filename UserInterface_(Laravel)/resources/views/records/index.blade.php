@extends('layouts.master')
@section('title', 'Records Overview')
@section('inhoud')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <br/>
                <h1>test</h1>
                @foreach( $items as $item )
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4>
                                    <p><a href="#">{{ $item->sord }}</a></p>
                                </h4><br>
                                <h4 class="pull-right">{{ $item->devicesn }}</h4>
                                <div class="topbar"><p>{{ $item->complaint }}</p></div>
                            </div>

                        </div>
                    </div>

                @endforeach
            </div>
        </div>
        <div class="row">
        </div>
    </div>
@stop
