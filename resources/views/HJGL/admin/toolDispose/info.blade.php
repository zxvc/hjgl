@extends('HJGL.admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 设备管理 <span
                class="c-gray en">&gt;</span> 设备列表 <span
                class="c-gray en">&gt;</span> 设备详情<a class="btn btn-success radius r btn-refresh"
                                                     style="line-height:1.6em;margin-top:3px"
                                                     href="javascript:location.replace(location.href);" title="刷新"
                                                     onclick="location.replace('{{URL::asset('admin/toolDispose/info')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div style="width:100%;height:120px;">
            <div style="float:left;margin-left:10px;width:600px;">
                <span class="l"><strong>{{$tool->number}}</strong></span><br/>
                <div class="l" style="width:300px;">
                    <br/>
                    <span class="l">商家名称: {{$tool->shop_id}}</span><br/><br/>
                    <span class="l">加入时间: {{$tool->create_time}}</span>
                </div>
                <div class="r"  style="width:300px;">
                    <br/>
                    <span class="l">设备状态: {{$tool->status}}</span>
                </div>
                <br/>
            </div>
            <div style="float:right;margin-right:10px;width:300px;">
                <span class="r"><a>检测结果</a></span><br/>
                <div class="r" style="width:150px;height:100px;border:1px solid">
                    <br/>
                    <span class="r">检测时长</span><br/>
                    <br/>
                    <span class="r">xx小时</span><br/>
                </div>
            </div>
        </div><br/>
        <div>
            <div class="l" style="width:400px;height:280px;border:1px solid">
                检测二维码
            </div>
            <div class="l" style="margin-left:10px;width:400px;height:280px;border:1px solid">
                <div style="margin:20%;">
                    @if($data->process == 0)
                        &nbsp;&nbsp;&nbsp;<i class="Hui-iconfont">&#xe631;</i>----------
                        <i class="Hui-iconfont">&#xe631;</i>----------
                        <i class="Hui-iconfont">&#xe631;</i>&nbsp;&nbsp;&nbsp;<br/>
                        待取回&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        待处理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        待送回
                    @elseif($data->process == 1)
                        &nbsp;&nbsp;&nbsp;<i class="Hui-iconfont" style="color:blue;">&#xe615;</i>----------
                        <i class="Hui-iconfont">&#xe631;</i>----------
                        <i class="Hui-iconfont">&#xe631;</i>&nbsp;&nbsp;&nbsp;<br/>
                        已取回&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        待处理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        待送回
                    @elseif($data->process == 2)
                        &nbsp;&nbsp;&nbsp;<i class="Hui-iconfont" style="color:blue;">&#xe615;----------</i>
                        <i class="Hui-iconfont" style="color:blue;">&#xe615;</i>----------
                        <i class="Hui-iconfont">&#xe631;</i>&nbsp;&nbsp;&nbsp;<br/>
                        已取回&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        已处理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        待送回
                    @else
                        &nbsp;&nbsp;&nbsp;<i class="Hui-iconfont" style="color:blue;">&#xe615;----------</i>
                        <i class="Hui-iconfont" style="color:blue;">&#xe615;----------</i>
                        <i class="Hui-iconfont" style="color:blue;">&#xe615;</i>&nbsp;&nbsp;&nbsp;<br/>
                        已取回&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        已处理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        已送回
                    @endif
                    <br/><br/><br/><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="btn btn-primary radius" style="cursor: pointer;" onclick="operate('{{$data->id}}','{{$data->process}}')">操作</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        /*
         * 设备处理--操作确认框
         *
         * By Yuyang
         *
         * 2018-12-07
         */
        function operate(id,process) {
            var text = '删除文章';
            if(process == 0){
                text = '设备是否已取回';
                layer.confirm(text, function () {
                    //此处请求后台程序，下方是成功后的前台处理
                    operate_do(id,process);
                });
            }else if(process == 1){
                text = '设备是否已处理';
                layer.confirm(text, function () {
                    //此处请求后台程序，下方是成功后的前台处理
                    operate_do(id,process);
                });
            }else if(process == 2){
                text = '设备是否已送回';
                layer.confirm(text, function () {
                    //此处请求后台程序，下方是成功后的前台处理
                    operate_do(id,process);
                });
            }else{
                alert('已是最终状态，无法在进行操作');
            }
        }
        /*
         * 设备处理--操作
         *
         * By Yuyang
         *
         * 2018-12-07
         */
        function operate_do(id,process) {
            var param = {
                id: id,
                process: process,
            }
            setToolDisposeStatus('{{URL::asset('')}}', param, function (ret) {
                if (ret.result == true) {
                    layer.msg('设置成功', {icon: 1, time: 1000});
                    window.location.reload();
                }
                else{
                    layer.msg(ret.message, {icon: 2, time: 1000});
                }
            });
        }
    </script>
@endsection