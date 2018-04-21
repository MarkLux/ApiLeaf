<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Api Leaf</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media screen and (max-width: 768px) {
                #logo{
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{url('/about')}}">使用指南</a>
                    @if (Auth::check())
                        <a href="{{ url('/home') }}" >主面板</a>
                    @else
                        <a href="{{ url('/login') }}" >登录</a>
                        <a href="{{ url('/register') }}" >注册</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{--<span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> Api Leaf--}}
                    Api Leaf
                    <span id="logo" onclick="onEggClick()">
                        <svg width="79px" height="75px" viewBox="0 0 79 75" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
        <g id="Artboard" transform="translate(-482.000000, -103.000000)" stroke="#646B6E" stroke-width="2.08571429">
            <g id="Group-5" transform="translate(89.000000, 83.000000)">
                <g id="Group" transform="translate(395.000000, 21.000000)">
                    <path d="M75.1787008,0.36373723 C73.6440152,12.2556029 80.2641411,72.3783849 10.6193906,65.651552 M1.58797644e-13,72.9920029 C6.83905244e-15,36.6778701 -0.556442602,14.8988535 75.1787008,0.36373723" id="Path"></path>
                </g>
            </g>
        </g>
    </g>
</svg>
                    </span>
                </div>

                <div class="links">
                    <p>一叶</p>
                </div>
                <div class="links">
                    <p>专为开发者定制的API测试和文档平台</p>
                </div>
            </div>
        </div>
        <script>
            var egg = 0;
            function onEggClick() {
                egg++;
                switch (egg%7) {
                    case 0:
                        changeTheme('#ffffff','#646B6E');
                        console.log("flies away.");
                        break;
                    case 1:
                        changeTheme('#4285f4','#ffffff');
                        console.log("The mighty desert");
                        break;
                    case 2:
                        changeTheme('#34a853','#ffffff');
                        console.log("is burning for the love");
                        break;
                    case 3:
                        changeTheme('#ff9900', '#ffffff');
                        console.log("of a bladeof grass");
                        break;
                    case 4:
                        changeTheme('#ff0033', '#ffffff');
                        console.log("who shakes her head");
                        break;
                    case 5:
                        changeTheme('#2FE1D6', '#ffffff');
                        console.log("and laughs");
                        break;
                    case 6:
                        changeTheme('#FFCD00', '#ffffff');
                        console.log("and");
                        break;
                }
            }

            function changeTheme(bgColor,fontColor) {
                var body = document.getElementsByTagName("body")[0];
                body.style.backgroundColor = bgColor;
                body.style.color = fontColor;
                var links = document.getElementsByTagName('a');
                for (var i = 0;i<links.length;i++) {
                    links[i].style.color = fontColor;
                }
                document.getElementById('Artboard').style.stroke = fontColor;
            }
        </script>
    </body>
</html>
