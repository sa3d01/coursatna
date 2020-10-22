@extends('dashboard.master.base')
@section('title',$title)
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
                            <div class="element-info">
                                <div class="element-info-with-icon">
                                    <div class="element-info-icon">
                                        <div class="os-icon os-icon-wallet-loaded"></div>
                                    </div>
                                    <div class="element-info-text">
                                        <h5 class="element-inner-header">
                                            إضافة
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @if(isset($create_fields))
                                <fieldset class="form-group">
                                    <div class="row">
                                        @foreach($create_fields as $key=>$value)
                                            <div class="col-sm-12">
                                                <div class="form-group" id="{{$value}}">
                                                    <label for=""> {{$key}}</label>
                                                    <input name="{{$value}}" class="form-control" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                            @endif
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
                                    </div>
                                </fieldset>
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
