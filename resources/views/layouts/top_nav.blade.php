<!--导航栏-->
<nav class="navbar navbar-default " style="height: 70px; font-size: larger;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style="padding-top: 10px">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <!-- <span class="icon-bar"></span> -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("/")}}" style="margin-left: -10px"><b>ApiLeaf</b>&nbsp<span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
            @if(isset($isDoc))
                <a class="navbar-brand" href="{{url("/api/doc/".$apiCollection->id)}}">文档</a>
                <a class="navbar-brand" href="{{url("/api/codes/".$apiCollection->id)}}">状态码</a>
                <a class="navbar-brand" href="#">数据字典</a>
            @endif
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-top: 10px">

            <ul class="nav navbar-nav navbar-right">
                <li>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-labelledby="dropdownMenu4">
                            {{\Illuminate\Support\Facades\Auth::user()->name}}           <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{url('/home')}}">主面板</a>
                            </li>
                            <li>
                                <a href="{{url('/api/test')}}">发起测试</a>
                            </li>
                            <li>
                                <a href="{{url('/logout')}}">登出</a>
                            </li>
                        </ul>
                    @else
                    @endif
                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>