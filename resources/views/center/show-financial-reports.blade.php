@extends('center.layouts.master-v-1-1')

@section('title', 'التقارير المالية')

@section('content')
    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">البيانات المالية للمركز</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">الشهر</th>
                                <th class="text-center">عدد الدورات</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">العائدات</th>
                                <th class="text-center">المبلغ المتوقع</th>
                                <th class="text-center">عرض الدورات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($details) > 0)
                                <?php $month = ""; ?>
                                @for($i = 0; $i < count(array_keys($details)); $i++)

                                    <tr class="gradeX">
                                        <td>
                                            {{ date("Y-F", strtotime(array_keys($details)[$i])) }}
                                        </td>
                                        <td>
                                            {{ $details[array_keys($details)[$i]][0] }}
                                        </td>

                                        <td>
                                            {{ $details[array_keys($details)[$i]][1] }}
                                        </td>

                                        <td>
                                            @if( $details[array_keys($details)[$i]][2] < $details[array_keys($details)[$i]][3] )
                                                {{ $details[array_keys($details)[$i]][2] }}
                                                <span class="fa fa-arrow-circle-down text-danger"></span>
                                            @elseif( $details[array_keys($details)[$i]][2] > $details[array_keys($details)[$i]][3] )
                                                {{ $details[array_keys($details)[$i]][2] }}
                                                <span class="fa fa-arrow-circle-up text-success"></span>
                                            @else
                                                {{ $details[array_keys($details)[$i]][2] }}
                                                <span class="fa fa-minus-circle text-warning"></span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $details[array_keys($details)[$i]][3] }}
                                        </td>
                                        <td>
                                            <a href="{{ route('center.financial.report.month', array_keys($details)[$i] ) }}">
                                                عرض
                                            </a>
                                        </td>
                                    </tr>
                                @endfor
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="8">
                                        <h3 class="mt-15">لم يتم إصدار اي شهادة لهذه الدورة</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection

@section('script-file')

@endsection