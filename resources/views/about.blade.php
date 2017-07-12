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
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1 style="font-size: 48px">
            一叶
            <small>a piece of leaf.<span id="logo">
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
                    </span></small>
        </h1>
    </div>
    <h3 style="font-size: 28px">说明文档&nbsp<small style="font-weight: lighter">[0.1.0 测试版]</small></h3>

    <br>

    <h3>1.一叶是什么？</h3>
    <div style="margin-left: 20px">
        <hr>
        <p>
            一叶·A piece of Leaf (英文简称<code>Api Leaf</code>),是一个面向后端开发人员的，用于进行API测试以及快速构建文档的工具和平台。
            <br>
            它能够帮助开发者测试API，并且根据测试的请求和响应结果自动解析快速生成对应的API文档，同时提供一个根据项目整理的文档平台。
            <br>
            一叶的目标是让后端开发者只专注在API的开发工作上，它可以协助你完成绝大部分与代码编写无关的工作：尤其是api文档的生成和维护，<br>这将大大节省你的时间。
        </p>
    </div>

    <h3>2.文档的生成流程</h3>
    <div style="margin-left: 20px">
        <hr>
        <ul style="line-height: 28px">
            <li>进行请求测试</li>
            <li>得到响应后点击生成文档，一叶将会根据你的响应结构自动解析生成文档的大致结构</li>
            <li>补充一些必要的信息</li>
            <li>一个接口的文档生成完毕</li>
        </ul>
        <p >
            * 注意：你需要注册并至少添加一个项目才能够进行上述操作
        </p>
    </div>

    <h3>3.文档的结构</h3>
    <div style="margin-left: 20px">
        <hr>
        <p>
            一个接口的文档被划分为以下几个模块:
        </p>
            <ul>
            <li>基本信息：名称、所属项目、描述</li>
            <li>请求URL</li>
            <li>请求方法(Method)</li>
            <li>请求参数：即QueryString中所包含的信息</li>
            <li>请求头部(Request Headers)</li>
            <li>请求内容(Request Body)</li>
            <li>请求示范(Request Example)</li>
            <li>响应头部(Response Headers)</li>
            <li>响应内容(Response Body)</li>
            <li>响应示范(Response Example)</li>
            </ul>
        <p>
            当你对一个接口发送一次测试请求后，一叶会帮你解析和填充上面所有的信息（如果存在)
            <br>
            你可以手动选择需要保留哪些信息，并且修改他们的内容
        </p>
    </div>

    <h3>4.交互规定</h3>
    <div style="margin-left: 20px">
        <hr>
        <p>
           文档的信息将会按照模块以<code>JSON</code>的形式存入系统，你需要按照规定的结构来填写相关的信息，否则文档将无法正常解析。
            <br>
            各个模块的JSON结构约定如下(给出的均为JSON的key)：
        </p>
        <ul>
            <li>请求参数(Query String)
                <ul><li><code>param_key</code> QueryString的key</li></ul>
                <ul><li><code>param_type</code> 该key对应的value的数据类型</li></ul>
                <ul><li><code>param_description</code> 该key的描述</li></ul>
            </li>
            <br>
            <li>请求头部和响应头部(Headers)
                <ul><li><code>header_key</code> Header的key</li></ul>
                <ul><li><code>header_type</code> 该key对应的value的数据类型</li></ul>
                <ul><li><code>header_description</code> 该key的描述</li></ul>
            </li>
            <br>
            <li>请求体和响应体(Body)
                <ul><li><code>body_key</code> Body的key</li></ul>
                <ul><li><code>body_type</code> 该key对应的value的数据类型</li></ul>
                <ul><li><code>body_description</code> 该key的描述</li></ul>
            </li>
        </ul>
        <p>
            可以看到，每个模块基本由key,type,description组成。
            <br>
            实际上，一叶将会根据请求测试的结果自动解析去填充key和type，以及层级结构。
            <br>
            绝大多数情况下你只用填写一下description就可以了。
            <br>
            文档生成后你仍然可以随时修改和删除。
        </p>
    </div>

    <h3>5.测试版本说明</h3>
    <div style="margin-left: 20px">
        <hr>
        <p>
            当前你看到的一叶为初次测试版本，功能还存在一定的局限性，使用时需要注意以下几点：
        </p>
        <ul>
            <li>请求和响应都必须是<code>application/json</code>格式，否则系统无法正常解析</li>
            <li>多人协作功能尚未加入，目前只能由项目的创建者向项目中添加文档</li>
        </ul>
        <p>
            欢迎每一位开发者提出宝贵的建议
        </p>
    </div>

    <h3>版权信息</h3>
    <div style="margin-left: 20px">
        <hr>
        <ul>
            <li>
                开发者：刘明@不洗碗工作室（marlx6590@163.com）
            </li>
            <li>
                源码地址：<a href="https://github.com/MarkLux/ApiLeaf">github</a>
            </li>
            <li>
                意见反馈：QQ-1065419610
            </li>
        </ul>
    </div>
    <footer>
        <hr>
        <p style="font-size: 13px;font-weight: 300">developed by MarkLux as a gift for 叶木杭.</p>
    </footer>
</div>

</body>
</html>