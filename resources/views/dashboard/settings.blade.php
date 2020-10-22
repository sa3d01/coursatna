@extends('dashboard.master.base')
@section('title','الاعدادات العامة')
@section('style')
    <link rel="stylesheet" href="{{asset('panel/dropify/dist/css/dropify.min.css')}}">
@endsection
@section('content')
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <div class="element-box">
                            <form method="POST" class="formValidate" enctype="multipart/form-data" action="{{ route('admin.setting.update') }}">
                                @csrf
                                <div class="element-info">
                                <div class="element-info-with-icon">
                                    <div class="element-info-icon">
                                        <div class="os-icon os-icon-wallet-loaded"></div>
                                    </div>
                                    <div class="element-info-text">
                                        <h5 class="element-inner-header">
                                            الإعدادات العامة
                                        </h5>
                                        <div class="element-inner-desc">
                                            يرجى تحرى الحظر خﻻل عمليات التعديل فى هذه التعديﻻت
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="white-box">
                                                    <label for="input-file-now-custom-1">اللوجو</label>
                                                    <input name="logo" type="file" id="input-file-now-custom-1" class="dropify" data-default-file="{{$row->logo}}"/>
                                                </div>
                                            </div>

                                            <div class="form-group" id="about_ar">
                                                <label> عن التطبيق باللغة العربية </label>
                                                <textarea name="about_ar" class="form-control" cols="80" rows="10">
                                                    {{$row->about_ar}}
                                                </textarea>
                                            </div>
                                            <div class="form-group" id="about_en">
                                                <label> عن التطبيق باللغة الانجليزية </label>
                                                <textarea name="about_en" class="form-control" cols="80" rows="10">
                                                    {{$row->about_en}}
                                                </textarea>
                                            </div>
                                            <div class="form-group" id="terms_ar">
                                                <label> شروط الاستخدام باللغة العربية </label>
                                                <textarea name="terms_ar" class="form-control" cols="80" rows="10">
                                                    {{$row->terms_ar}}
                                                </textarea>
                                            </div>
                                            <div class="form-group" id="terms_en">
                                                <label> شروط الاستخدام باللغة الانجليزية </label>
                                                <textarea name="terms_en" class="form-control" cols="80" rows="10">
                                                    {{$row->terms_en}}
                                                </textarea>
                                            </div>

                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-buttons-w">
                                    <button class="btn btn-primary create-submit" type="submit"> تعديل</button>
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
                    console.log(value)
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
