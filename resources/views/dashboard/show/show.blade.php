@extends('dashboard.master.base')
@section('title',$title)
@section('style')
    <style>
        .image-upload > input {
            visibility:hidden;
            width:0;
            height:0
        }
    </style>
    <link rel="stylesheet" href="{{asset('panel/dropify/dist/css/dropify.min.css')}}">
    <style>
        .sale_map
        {
            position: absolute !important;
            height: 100% !important;
            width: 100% !important;
        }
        .wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .file-upload {
            height: 200px;
            width: 200px;
            border-radius: 100px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 4px solid #FFFFFF;
            overflow: hidden;
            background-image: linear-gradient(to bottom, #2590EB 50%, #FFFFFF 50%);
            background-size: 100% 200%;
            transition: all 1s;
            color: #FFFFFF;
            font-size: 100px;
        }
        .file-upload input[type='file']{
            height:200px;
            width:200px;
            position:absolute;
            top:0;
            left:0;
            opacity:0;
            cursor:pointer;
        }
    </style>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKhmEeCCFWkzxpDjA7QKjDu4zdLLoqYVw&language=ar&&callback=initMap&libraries=places" type="text/javascript">
    </script>

    <script type="text/javascript">
        let new_map;
        let old_map;
        let marker;
        function initMap() {
            if (!document.getElementById('show_sale_map')){
                 marker = false;
            }else {
                // show map
                let lat_str = document.getElementById('show_sale_map').getAttribute("data-lat");
                let long_str = document.getElementById('show_sale_map').getAttribute("data-lng");
                let uluru = {lat:parseFloat(lat_str), lng: parseFloat(long_str)};
                let centerOfOldMap = new google.maps.LatLng(uluru);
                let oldMapOptions = {
                    center: centerOfOldMap,
                    zoom: 14
                };
                old_map = new google.maps.Map(document.getElementById('show_sale_map'), oldMapOptions);
                marker = new google.maps.Marker({position: centerOfOldMap,animation:google.maps.Animation.BOUNCE});
                marker.setMap(old_map);
                // end show map
            }
            // new map
            let centerOfNewMap = new google.maps.LatLng(24.665658,46.7440368);
            let newMapOptions = {
                center: centerOfNewMap,
                zoom: 14
            };
            new_map = new google.maps.Map(document.getElementById('sale_map'), newMapOptions);
            // end new map
            google.maps.event.addListener(new_map, 'click', function(event) {
                let clickedLocation = event.latLng;
                if(marker === false){
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: new_map,
                        draggable: true
                    });
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        markerLocation();
                    });
                } else{
                    marker.setPosition(clickedLocation);
                }
                markerLocation();
            });
        }
        function markerLocation(){
            let currentLocation = marker.getPosition();
            document.getElementById('lat').value = currentLocation.lat();
            document.getElementById('lng').value = currentLocation.lng();
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
@endsection
@section('content')
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-sm-5">
                    <div class="user-profile compact">
                        @include('dashboard.show.first-box')
                    </div>
                    @if(isset($cards))
                    <div class="element-wrapper">
                        @include('dashboard.show.card-box')
                    </div>
                    @endif
                    <div class="element-wrapper">
                        @include('dashboard.show.activity-box')
                    </div>
                </div>
                @if(isset($only_show) && $only_show==true)
                    @include('dashboard.show.show-box')
                @else
                    @include('dashboard.show.edit-box')
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('panel/dropify/dist/js/dropify.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).on('click', '.block', function (e) {
            // console.log($(this).data('href'))
            e.preventDefault();
            // Swal.fire({
            //     title: 'من فضلك اذكر سبب الحظر',
            //     input: 'text',
            //     showCancelButton: true,
            //     confirmButtonText: 'حظر',
            //     showLoaderOnConfirm: true,
            //     preConfirm: (block_reason) => {
            //         $.ajax({
            //             url: $(this).data('href'),
            //             type:'GET',
            //             data: {block_reason}
            //         })
            //     },
            //     allowOutsideClick: () => !Swal.isLoading()
            // }).then(() => {
            //     location.reload(true);
            // })
            /////////////////
            Swal.fire({
                title: "هل انت متأكد من الحظر ؟",
                text: "تأكد من اجابتك قبل التأكيد!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'نعم , قم بالحظر!',
                cancelButtonText: 'ﻻ , الغى عملية الحظر!',
                closeOnConfirm: false,
                closeOnCancel: false,
                preConfirm: () => {
                    $.ajax({
                        url: $(this).data('href'),
                        type:'GET',
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(() => {
                    location.reload(true);
                })
        });
    </script>
    @if($errors->any())
        <div style="visibility: hidden" id="errors" data-content="{{$errors}}"></div>
        <script type="text/javascript">
            $(document).ready(function () {
                var errors=$('#errors').attr('data-content');
                $.each(JSON.parse(errors), function( index, value ) {
                    // $('input[name="note"]').notify(
                    $('#'+index).notify(
                        value,
                        'error',
                        { position:"top" }
                    );
                });
            })
        </script>
    @endif
    <script type="text/javascript">
        $('#image_preview').html("");
        var files=JSON.parse($("#uploadFile").attr('data-images'));
        for(var i=0;i<files.length;i++)
        {
            $('#image_preview').append("<img style='pointer-events: none;max-height: 100px;max-width: 100px;margin-right: 5px;margin-left: 5px;border-radius: 10px;' src='https://top-auction.com/media/images/sale/"+files[i]+"'>");
        }
        $("#uploadFile").change(function(){
            $('#image_preview').html("");
            var total_file=document.getElementById("uploadFile").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#image_preview').append("<img style='pointer-events: none;max-height: 100px;max-width: 100px;margin-right: 5px;margin-left: 5px;border-radius: 10px;' src='"+URL.createObjectURL(event.target.files[i])+"'>");
            }
        });
        window.onload = function (){
            if($('#category_id').val()==1){
                $('#marks').removeAttr('hidden');
                $('#models').removeAttr('hidden');
                $('#color').removeAttr('hidden');
                $('#year').removeAttr('hidden');
            }
            $('#category_id').change(function (){
                let category_id = $('#category_id').val();
                if(category_id==1){
                    $('#marks').removeAttr('hidden');
                    $('#models').removeAttr('hidden');
                    $('#color').removeAttr('hidden');
                    $('#year').removeAttr('hidden');
                }else {
                    $('#marks').attr('hidden','hidden');
                    $('#models').attr('hidden','hidden');
                    $('#color').attr('hidden','hidden');
                    $('#year').attr('hidden','hidden');
                }
            });
            $('#mark_id').change(function (){
                var mark_id = $('#mark_id').val();
                $.ajax({
                    type: "GET",
                    url:'/admin/get_models/'+mark_id,
                    dataType: 'json',
                    success: function( data ) {
                        console.log(data)
                        $('#models').empty();
                        var res = '<div class="form-group"><label for=""> الموديل </label><select id="model_id" name="model_id" class="form-control">';
                        $.each (data, function (key, value)
                        {
                            res +=
                                '<option value="'+value.id+'">'+value.name+'</option>';
                        });
                        res +='</select></div></div>';
                        $('#models').html(res);
                    }
                });
            });
        };


/////////////////////////////
        $.ajaxSetup({
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $("#pdf").change(function(e){
        //     e.preventDefault();
        //     var pdf = $(this).get()[0].files[0];
        //     alert('قم بالضغط على تعديل البيانات للتغير الى الملف الجديد '+pdf['name']);
        //     // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     // var pdf = $(this).get()[0].files[0];
        //     // var data = {_token: CSRF_TOKEN, pdf: pdf , message:'a7a', _method: 'POST'};
        //     // console.log(data)
        //     // console.log($(this).get())
        //     // $.ajax({
        //     //     dataType: 'json',
        //     //     // async: true,
        //     //     // crossDomain: true,
        //     //     // contentType: false,
        //     //     processData: false,
        //     //     // cache: false,
        //     //     enctype: 'multipart/form-data',
        //     //     url: "/admin/show_pdf",
        //     //     type: 'POST',
        //     //     headers:
        //     //         {
        //     //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     //         },
        //     //     data: data,
        //     //     success: function(res) {
        //     //         console.log(res)
        //     //         $('#iframe').attr('src',"https://docs.google.com/gview?url="+res+"&embedded=true");
        //     //     },error:function (msg){
        //     //         console.log(msg.responseJSON['message'])
        //     //     }
        //     // })
        // });
        $("#pdf").change(function(){
            $('#pdf_preview').html("");
            var total_file=document.getElementById("pdf").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#pdf_preview').append("" +
                    "<iframe src='"+URL.createObjectURL(event.target.files[i])+"' style='width:100%; height:500px;'></iframe>");
            }
        });
/////////////////////
    </script>

@endsection
