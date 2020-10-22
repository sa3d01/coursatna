<div class="row">
    @if($type=='sale')
                <div class="col-sm-6">
                    <a class="element-box el-tablo centered trend-in-corner padded bold-label">
                        <div class="value">
                            {{$row->category->name['ar']}}
                        </div>
                        <div class="label">
                            القسم
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a class="element-box el-tablo centered trend-in-corner padded bold-label">
                        <div class="value">
                            {{$row->id}}
                        </div>
                        <div class="label">
                            الرقم التسلسلى للمزاد
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a class="element-box el-tablo centered trend-in-corner padded bold-label">
                        <div class="value">
                            {{$row->currentPrice()}}
                        </div>
                        <div class="label">
                            السعر الأخير
                        </div>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a class="element-box el-tablo centered trend-in-corner padded bold-label">
                        <div class="value">
                            {{$row->countUserSales()}}
                        </div>
                        <div class="label">
                            عدد المزايدات
                        </div>
                    </a>
                </div>
                @if($winner_user_id != null)
                <div class="col-sm-6">
                    <a class="element-box el-tablo centered trend-in-corner padded bold-label" href="{{route('admin.user.show',[$winner_user_id])}}">
                        <div class="value">
                            {{\App\User::whereId($winner_user_id)->value('name')}}
                        </div>
                        <div class="label">
                            الأعلى مزايدة
                        </div>
                    </a>
                </div>
                @endif
    @endif
</div>
