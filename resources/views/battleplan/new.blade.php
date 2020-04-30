@extends('layouts.main')

@push('js')
<script>

    
    $( function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#map-list .map-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    } );
  
function selectMap(dom, mapId){
    $('#map_id').val(mapId);
    $(".map-item").removeClass("selected");
    $(dom).addClass("selected");
}

</script>
@endpush

@push('css')
<style>
    #map-list{
        height:400px;
        overflow: auto;
        border-style: solid;
        border-width: 5px;
    }
    .map-item.selected{
        background-color: #00ff08;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <h1 class="text-center">Create Battleplan</h1>
        <form action="/battleplan" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Battleplan Name" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Battleplan Description"></textarea>
            </div>
            <hr>
            
            <div class="form-group">
                <h2 class="text-center">Map</h2>
                <input id="search" type="text" class="col-12" placeholder="Search..">
                <input type="hidden" name="map_id" id="map_id" required>
                <div id="map-list" class="overflow-auto mt-2">

                    @foreach($maps as $map)
                    <div class="map-item row m-3" onclick="selectMap(this, {{$map->id}})">
                        <div class="col-4">
                            <img src="https://battleplanner-production.s3.ca-central-1.amazonaws.com{{$map->thumbnail->path}}" class="card-img-top" alt="...">
                        </div>
                        
                        <div class="col-4">
                            <h4>{{$map->name}}</h4>
                        </div>
                    </div>
                        <hr>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary col-12">Submit</button>
        </form>


    </div>
</div>

@endsection