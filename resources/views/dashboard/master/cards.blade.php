<div class="row">
    <div class="col-sm-12">
        <div class="element-wrapper">
            <h6 class="element-header">
                آخر الإحصائيات
            </h6>
            <?php
            if(\Auth::user()->getRoleArabicName()=='TEACHER'){
                $teacher=\App\Models\User::find(\Auth::user()->id);
                $courses_count=\App\Models\Course::where('teacher_id',\Auth::user()->id)->count();
                $level_ids=\App\Models\Level::whereJsonContains('subjects', $teacher->subject_id)->pluck('id');
                $users_count=\App\Models\User::whereType('USER')->whereIn('level_id',$level_ids)->count();
                $debits=\App\Models\Center::where('id',$teacher->center_id)->value('debit');
            }else{
                $users_count=\App\Models\User::whereType('USER')->count();
                $courses_count=\App\Models\Course::count();
                $debits=\App\Models\Center::sum('debit');
            }
            ?>
            <div class="element-content">
                <div class="row">
                    <div class="col-sm-4 col-xxxl-3">
                        <a class="element-box el-tablo" href="#">
                            <div class="label">
                                عدد المستخدمين
                            </div>
                            <div class="value">

                                {{$users_count}}
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4 col-xxxl-3">
                        <a class="element-box el-tablo" href="#">
                            <div class="label">
                                عدد الكورسات
                            </div>
                            <div class="value">
                                {{$courses_count}}
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4 col-xxxl-3">
                        <a class="element-box el-tablo" href="#">
                            <div class="label">
                                اجمالى المستحقات
                            </div>
                            <div class="value">
                                {{$debits}} جنيه
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
