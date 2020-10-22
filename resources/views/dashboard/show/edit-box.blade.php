<div class="col-sm-7">
    <div class="element-wrapper">
        <div class="element-box">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
                @if(isset($edit_fields))
                <form class="POST" name="update" enctype="multipart/form-data" method="POST" action="{{route($action,$row->id)}}" id="formValidate">
                    @csrf
                    {{ method_field('PUT') }}
                <div class="element-info">
                    <div class="element-info-with-icon">
                        <div class="element-info-icon">
                            <div class="os-icon os-icon-wallet-loaded"></div>
                        </div>
                        <div class="element-info-text">
                            <h5 class="element-inner-header">
                                 تعديل البيانات
                            </h5>
                            @if(isset($edit_alert))
                                <div class="element-inner-desc">
                                    {{$edit_alert}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                    <fieldset class="form-group">
                        <div class="row">
                            @foreach($edit_fields as $key=>$value)
                                @if(isset($languages) && $languages==true)
                                    @foreach($settings->languages as $lang)
                                        @if($value=='note')
                                            <div class="col-sm-12">
                                                <div class="form-group" id="{{$value}}.{{$lang}}">
                                                    <label> {{$key}} </label>
                                                    <textarea name="{{$value}}.{{$lang}}" class="form-control" cols="80" rows="10" id="ckeditor1">
                                                        {{$row->$value[$lang]}}
                                                    </textarea>
                                                </div>
                                            </div>
                                        @elseif(strpos($value, 'price'))
                                            <div class="col-sm-12">
                                                <div class="form-group" id="{{$value}}">
                                                    <label for=""> {{$key}}</label>
                                                    <input name="{{$value}}" class="form-control" value="{{$row->$value}}" type="number" min="1">
                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>
                                        @elseif($value=='start_date' || $value=='end_date')
                                            <div class="col-sm-12" id="{{$value}}">
                                                <div class="form-group row">
                                                    <label for="{{$value}}" class="col-2 col-form-label">{{$key}}</label>
                                                    <input name="{{$value}}" value="{{$row->$value}}" class="form-control" type="datetime-local" id="{{$value}}">
                                                </div>
                                            </div>
                                        @elseif($value=='images')
                                            <div class="col-sm-12" id="{{$value}}">
                                                <div class="form-group row">
                                                    <label for="{{$value}}" class="col-2 col-form-label">{{$key}}</label>
                                                    <input class="upload form-control" id="uploadFile" type="file" data-images="{{$row->imagesArray()}}" accept="image/*" name="images[]" multiple />
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group" id="image_preview"></div>
                                        @elseif(substr($value, "-3")=='_id')
                                            @php
                                                $marks=\App\DropDown::where(['class'=>'Mark','status'=>1])->get();
                                            @endphp
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for=""> الماركة </label>
                                                    <select name="parent_id" class="form-control">
                                                        <option value="{{$row->parent->id}}">
                                                            {{$row->parent->name['ar']}}
                                                        </option>
                                                        @foreach($marks as $mark)
                                                            <option value="{{$mark->id}}">
                                                                {{$mark->name['ar']}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>@else
                                            <div class="col-sm-12">
                                                <div class="form-group" id="{{$value}}.{{$lang}}">
                                                    <label for=""> {{$key}}</label><input name="{{$value}}.{{$lang}}" class="form-control" value="{{$row->$value[$lang]}}" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @if($value=='note')
                                        <div class="col-sm-12">
                                            <div class="form-group" id="{{$value}}">
                                                <label> {{$key}} </label>
                                                <textarea name="{{$value}}" class="form-control" cols="80" rows="10">
                                                        {{$row->$value}}
                                                    </textarea>
                                            </div>
                                        </div>
                                    @elseif(strpos($value, 'price'))
                                        <div class="col-sm-12">
                                            <div class="form-group" id="{{$value}}">
                                                <label for=""> {{$key}}</label>
                                                <input name="{{$value}}" value="{{$row->$value}}" class="form-control" type="number" min="1">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>
                                    @elseif($value=='start_date' || $value=='end_date')
                                        <div class="col-sm-12" id="{{$value}}">
                                            <div class="form-group row">
                                                <label for="{{$value}}" class="col-2 col-form-label">{{$key}}</label>
                                                <input name="{{$value}}"  value="{{$row->$value}}" class="form-control" type="datetime-local" id="{{$value}}">
                                            </div>
                                        </div>
                                    @elseif($value=='images')
                                        <div class="col-sm-12" id="{{$value}}">
                                            <div class="form-group row">
                                                <label for="{{$value}}" class="col-2 col-form-label">{{$key}}</label>
                                                <input class="upload form-control" id="uploadFile" type="file" data-images="{{$row->imagesArray()}}" accept="image/*" name="images[]" multiple />
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="form-group" id="image_preview"></div>
                                    @elseif(substr($value, "-3")=='_id')
                                        @php
                                            $marks=\App\DropDown::where(['class'=>'Mark','status'=>1])->get();
                                        @endphp
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for=""> الماركة </label>
                                                <select name="parent_id" class="form-control">
                                                    <option value="{{$row->parent->id}}">
                                                        {{$row->parent->name['ar']}}
                                                    </option>
                                                    @foreach($marks as $mark)
                                                        <option value="{{$mark->id}}">
                                                            {{$mark->name['ar']}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($value=='role')
                                        <div class="col-sm-12" id="roles">
                                            <div class="form-group">
                                                <label for=""> الدور </label>
                                                <select id="role_id" name="role_id" class="form-control">
                                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                        <option @if($row->hasRole($role->name)) selected @endif value="{{$role->id}}">
                                                            {{$role->blank}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <div class="form-group" id="{{$value}}">
                                                <label for=""> {{$key}}</label><input name="{{$value}}" class="form-control" value="{{$row->$value}}" type="text">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                                @if($row->type=='sale')
                                    @php
                                        $drop_down_rows=\App\DropDown::where(['class'=>$select['class'],'status'=>1])->get();
                                        $marks=\App\DropDown::where(['class'=>'Mark','status'=>1])->get();
                                        $models=\App\DropDown::where(['class'=>'Model','parent_id'=>$marks->first()->id,'status'=>1])->get();
                                        $related_model=substr_replace($select['input_name'], "", -3);
                                        try {
                                            $related_model_id=$row->$related_model->id;
                                            $related_model_val=$row->$related_model->name['ar'];
                                        }catch (Exception $e){
                                            $related_model_id=$row->mark->id;
                                            $related_model_val=$row->mark->name['ar'];
                                        }
                                    @endphp
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""> {{$select['name']}} </label>
                                            <select id="{{$select['input_name']}}" name="{{$select['input_name']}}" class="form-control">
                                                <option value="{{$related_model_id}}">
                                                    {{$related_model_val}}
                                                </option>
                                                @foreach($drop_down_rows as $drop_down_row)
                                                    <option value="{{$drop_down_row->id}}">
                                                        {{$drop_down_row->name['ar']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="marks" hidden>
                                        <div class="form-group">
                                            <label for=""> الماركة </label>
                                            <select id="mark_id" name="mark_id" class="form-control">
                                                <option value="{{$row->model->parent->id}}">
                                                    {{$row->model->mark->name['ar']}}
                                                </option>
                                                @foreach($marks as $mark)
                                                    <option value="{{$mark->id}}">
                                                        {{$mark->name['ar']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="models" hidden>
                                        <div class="form-group">
                                            <label for=""> الموديل </label>
                                            <select id="model_id" name="model_id" class="form-control">
                                                <option value="{{$row->model->id}}">
                                                    {{$row->model->name['ar']}}
                                                </option>
                                                @foreach($models as $model)
                                                    <option value="{{$model->id}}">
                                                        {{$model->name['ar']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="color" class="col-sm-12" hidden>
                                        <div class="form-group">
                                            <label for="">اللون</label>
                                            <select id="color" name="color" class="form-control">
                                                @php($selected_color=\App\DropDown::where('name->ar',$row->color)->first())
                                                <option style="background-color:{{$selected_color->more_details['hexa']?? '#FFF'}}" value="{{$row->color}}">
                                                    {{$row->color}}
                                                </option>
                                                @foreach(\App\DropDown::where('class','Color')->get() as $color)
                                                    <option style="background-color:{{$color->more_details['hexa']?? '#FFF'}}" value="{{$color->name['ar']}}">
                                                        {{$color->name['ar']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="year" class="col-sm-12" hidden>
                                        <div class="form-group">
                                            <label for="">سنة الصنع</label>
                                            <select id="year" name="year" class="form-control">
                                                <option value="{{$row->year}}">
                                                    {{$row->year}}
                                                </option>
                                                @for($year=1980;$year<=2040;$year++)
                                                    <option value="{{$year}}">
                                                        {{$year}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endif
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
                                @if(isset($order_by))
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">الترتيب الرقمى</label><input name="order_by" class="form-control" min="1" value="{{$row->order_by}}" placeholder="الترتيب الرقمى" type="number">
                                        </div>
                                    </div>
                                @endif
                                @if(isset($image))
                                    <div class="col-sm-6">
                                        <div class="white-box">
                                            <label for="input-file-now-custom-1">الصورة</label>
                                            <input name="image" type="file" id="input-file-now-custom-1" class="dropify" data-default-file="{{$row->image}}"/>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($pdf))
                                    <div class="col-sm-12">
                                        <label for="pdf">تقرير الفحص</label>
                                        <div>
                                            <input id="pdf" name="pdf" type="file" accept="application/pdf"/>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="col-sm-12 form-group" id="pdf_preview">
                                        @if($row->pdf!=null)
                                            <iframe id="iframe" src="https://docs.google.com/gview?url=https://top-auction.com/media/files/{{$row->pdf}}&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>
                                        @endif
                                    </div>
                                    <br>
                                @endif
                                @if(isset($address))
                                    <div class="col-sm-12">
                                        <div class="card-img" style="height: 400px">
                                            <label for="sale_map">الموقع</label>
                                            <input id="pac-input" name="address_search"
                                                   class="controls" value="{{old('address_search')}}"
                                                   type="text"
                                                   style="z-index: 1; position: absolute;  top: 10px !important;
		                                            left: 197px; height: 40px;   width: 63%;   border: none;  box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; padding: 0 1em;   color: rgb(86, 86, 86);
		                                            font-family: Roboto, Arial, sans-serif;   user-select: none;  font-size: 18px;   margin: 10px;"  placeholder="بحث"  >
                                            <div id="sale_map" data-lat="{{$row->address['lat']}}" data-lng="{{$row->address['lng']}}" class="sale_map"></div>
                                            <input name="lat" type="hidden" id="lat">
                                            <input name="lng" type="hidden" id="lng">
                                            <input name="address" type="hidden" id="address">
                                        </div>
                                    </div>
                                @endif
                                @if(isset($permissions))
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""> الصﻻحيات</label>
                                            <select name="permissions[]" class="form-control select2" multiple="true">
                                                @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                                    <option value="{{$permission->name}}" @if($row->hasPermissionTo($permission->id)) selected="true" @endif>
                                                        {{$permission->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                        </div>
                    </fieldset>
                    <div class="form-buttons-w">
                        <button class="btn btn-primary edit-submit" type="submit"> تعديل</button>
                    </div>
                </form>
                @endif
        </div>
    </div>
</div>

