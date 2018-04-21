<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A piece of Leaf</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', 'Microsoft YaHei', sans-serif;
            font-weight: lighter;
        }

        h1 {
            font-weight: lighter;
        }

        h2 {
            font-weight: lighter;
        }

        h3 {
            font-weight: lighter;
        }

        h4 {
            font-weight: lighter;
        }

        p {
            font-size: 16px;
            line-height: 28px
        }

        ul {
            font-size: 16px;
            line-height: 28px
        }
        .layout {
            display: flex;

        }
        .left {
            max-height: 100vh;
            flex: 0 0 200px;
            width: 30%;
            overflow: scroll;
            margin-left: 0px;
            padding-right: 20px;
        }
        .right {
            flex: auto;
            max-height: 100vh;
            overflow: scroll;
            padding-right: 20px;
        }
        @media screen and (max-width: 768px) {
            .left{
                display:none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h3 style="font-size: 36px">
            ApiLeaf
            <span id="logo">
                        <svg width="33px" height="30px" viewBox="0 0 79 75" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

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
            <small style="font-size: 15px">version 1.0</small>
        </h3>
    </div>
    <h3 style="font-size: 28px">使用文档&nbsp</h3>

    <br>

    <div class="layout">
        <div class="left">
                    <h3>目录</h3>
                    <ul class="list-group">
                        <a class="list-group-item" onclick="activeDoc('intro')">简介</a>
                        <a class="list-group-item" onclick="activeDoc('http-test')">接口测试</a>
                        <a class="list-group-item" onclick="activeDoc('doc-generate')">文档生成</a>
                        <a class="list-group-item" onclick="activeDoc('doc-manage')">文档管理</a>
                        <a class="list-group-item" onclick="activeDoc('data-dict')">数据字典</a>
                        <a class="list-group-item" onclick="activeDoc('team-work')">团队协作</a>
                        <a class="list-group-item" onclick="activeDoc('doc-read')">阅读文档</a>
                        <a class="list-group-item" onclick="activeDoc('about-info')">关于</a>
                    </ul>
        </div>
        <div class="right">
            @include('docs.intro')
            @include('docs.http_test')
            @include('docs.doc_generate')
            @include('docs.doc_manage')
            @include('docs.data_dict')
            @include('docs.team_work')
            @include('docs.doc_read')
            @include('docs.about_info')
        </div>

</div>
    <footer>
        <hr>
        <p style="font-size: 13px;font-weight: 300; color: #ffffff">once developed by Lumin as a gift for 叶木杭.</p>
    </footer>
</div>
<script>
    function activeDoc(part) {
        var docDivs = document.getElementsByClassName('doc');
        for (var i=0; i< docDivs.length; i++) {
            docDivs[i].style.display = 'none';
        }
        document.getElementById(part).style.display = 'block';
    }
</script>
</body>
</html>