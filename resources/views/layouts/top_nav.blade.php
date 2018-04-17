<!--导航栏-->
<nav class="navbar navbar-default ">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <!-- <span class="icon-bar"></span> -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("/")}}">ApiLeaf&nbsp<span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

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