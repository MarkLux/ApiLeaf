<!--导航栏-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <!-- <span class="icon-bar"></span> -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("/")}}">ApiBuilder</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class = "dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-labelledby="dropdownMenu4">
                        请求测试
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('blog')}}">全部</a></li>
                    </ul>
                </li>
                <li><a href="{{url('calendar')}}"></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    登录
                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>