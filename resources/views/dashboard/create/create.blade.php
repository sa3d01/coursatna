@extends('dashboard.master.base')
@section('title',$title)
@section('style')
    <link rel="stylesheet" href="{{asset('panel/dropify/dist/css/dropify.min.css')}}">
@endsection
@section('content')
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="element-box">
                            <form class="formValidate" method="POST" action="{{ route($action) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @if(isset($section_id))
                                    <input name="section_id" value="{{$section_id}}" type="hidden">
                                @endif
                            <div class="element-info">
                                <div class="element-info-with-icon">
                                    <div class="element-info-icon">
                                        <div class="os-icon os-icon-wallet-loaded"></div>
                                    </div>
                                    <div class="element-info-text">
                                        <h5 class="element-inner-header">
                                            إضافة
                                        </h5>
                                        @if(isset($create_alert))
                                            <div class="element-inner-desc">
                                                {{$create_alert}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(isset($create_fields))
                                <fieldset class="form-group">
                                    <div class="row">
                                        @foreach($create_fields as $key=>$value)
                                            @if($value=='note')
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="{{$value}}">
                                                        <label> {{$key}} </label>
                                                        <textarea name="{{$value}}" class="form-control" cols="80" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            @elseif(strpos($value, 'price'))
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="{{$value}}">
                                                        <label for=""> {{$key}}</label>
                                                        <input name="{{$value}}" class="form-control" type="number" min="1">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            @elseif($value=='complexity')
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="{{$value}}">
                                                        <label for=""> {{$key}}</label>
                                                        <input name="{{$value}}" class="form-control" type="number" min="1" max="10">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            @elseif($value=='start_date' || $value=='end_date')
                                                <div class="col-sm-12" id="{{$value}}">
                                                    <div class="form-group row">
                                                        <label for="{{$value}}" class="col-2 col-form-label">{{$key}}</label>
                                                        <input name="{{$value}}" class="form-control" type="datetime-local" id="{{$value}}">
                                                    </div>
                                                </div>
                                            @elseif($value=='role')
                                                <div class="col-sm-12" id="roles">
                                                    <div class="form-group">
                                                        <label for=""> الدور </label>
                                                        <select id="role_id" name="role_id" class="form-control">
                                                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                                <option value="{{$role->id}}">
                                                                    {{$role->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="{{$value}}">
                                                        <label for=""> {{$key}}</label>
                                                        <input name="{{$value}}" class="form-control" type="text">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                            @if(isset($password))
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> كلمة المرور</label><input name="password" class="form-control" data-minlength="6" placeholder="كلمة المرور" type="password">
                                                        <div class="help-block form-text text-muted form-control-feedback">
                                                            يجب أﻻ يقل عن 6 خانات على الأقل
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($image))
                                                <div class="col-sm-6">
                                                    <div class="white-box">
                                                        <label for="input-file-now-custom-1">الصورة</label>
                                                        <input name="image" type="file" id="input-file-now-custom-1 image" class="dropify" data-default-file="{{asset('media/images/course/default.png')}}"/>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($pdf))
                                                <div class="col-sm-12">
                                                    <label for="pdf">الملف</label>
                                                    <div class="wrapper">
                                                        <div class="file-upload">
                                                            <input id="pdf" name="file" type="file" accept="application/pdf"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="col-sm-12 form-group" id="pdf_preview"></div>
                                            @endif
                                            @if(isset($video))
                                                <div class="col-sm-12">
                                                    <label for="file">الفديو</label>
                                                    <div class="wrapper">
                                                        <div class="file-upload">
                                                            <input id="pdf" name="file" type="file"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="col-sm-12 form-group" id="pdf_preview" accept="video/mp4,video/x-m4v,video/*"></div>
                                            @endif
                                            @if(isset($selects))
                                                @foreach($selects as $select)
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for=""> {{$select['title']}} </label>
                                                        <select id="{{$select['input_name']}}" name="{{$select['input_name']}}" class="form-control">
                                                            @foreach($select['rows'] as $row)
                                                                <option value="{{$row->id}}">
                                                                    {{$row->nameForSelect()}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif

                                            @if(isset($multi_select))
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for=""> {{$multi_select['title']}}</label>
                                                        <select name="{{$multi_select['input_name']}}[]" class="form-control select2" multiple="true">
                                                            @foreach($multi_select['rows'] as $multi_select_row)
                                                                <option value="{{$multi_select_row->id}}" @if($loop->first) selected="true" @endif>
                                                                    {{$multi_select_row->nameForSelect()}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($permissions))
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for=""> الصﻻحيات</label>
                                                        <select name="permissions[]" class="form-control select2" multiple="true">
                                                            @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                                                <option value="{{$permission->name}}" @if($loop->first) selected="true" @endif>
                                                                    {{$permission->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                    </div>
                                </fieldset>
                            @endif
                            <div class="form-buttons-w">
                                <button class="btn btn-primary create-submit" type="submit"> إضافة</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $("#pdf").change(function(){
            $('#pdf_preview').html("");
            var total_file=document.getElementById("pdf").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#pdf_preview').append("" +
                    "<iframe src='"+URL.createObjectURL(event.target.files[i])+"' style='width:100%; height:500px;'></iframe>");
            }
        });
    </script>

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
@stop
