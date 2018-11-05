<div id="http-test" class="doc" style="display: none">
    <blockquote>
        <h3 style="font-size: 40px">
            HTTP 测试
        </h3>
    </blockquote>
    <h3>
        0*. 创建一个项目
    </h3>
    <hr>
    <p>
        为了能够更好的理解Api Leaf的工作流程，强烈建议在尝试HTTP测试功能前，先创建一个<b>项目</b>。
        <br>
        你可以阅读<a onclick="activeDoc('doc-manage')">文档管理</a>的第一部分了解如何创建一个项目。
    </p>
    <br>
    <h3>
        1. 打开测试面板
    </h3>
    <hr>
    <p>
        在开始进行一个HTTP测试之前，你首先需要<a href="{{url('/register')}}"><b>注册</b></a>一个账号并<a href="{{url('/login')}}"><b>登录</b></a>。
        <br>
        登录后，在主页点击右上角的<b>主面板</b>进入你的用户空间，然后继续点击右上角的用户名下拉菜单，选择<b>发起测试</b>，之后便可进入测试界面。
        <img src="http://cdn.marklux.cn/18-4-22/62289291.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
    </p>
    <br>
    <h3>
        2. 填写并发送请求
    </h3>
    <hr>
    <p>
        在测试面板的Request部分可以定制你的请求，如下图：
        <img src="http://cdn.marklux.cn/18-4-22/4824403.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        选择请求方式，填写<b>以http(s)://开头的完整URL地址</b>，<br>
        你可以在Headers和Body选项卡中以<b>JSON</b>的形式定制HTTP请求的headers和body。
        <br>
        最后点击发送请求，页面将会使用<code>fecth</code>发送这个定制的请求，并将结果填入下方Response部分的编辑框中。
    </p>
    <br>
    <h3>
        3. 获取和编辑响应结果
    </h3>
    <hr>
    <p>
        发送请求后，如果正常拿到响应，其Headers和Body将分别以<b>JSON</b>的形式填入下方的Response部分中，如下图所示：
        <img src="http://cdn.marklux.cn/18-4-22/47318931.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        面板的顶部会显示响应返回的<code>Status Code</code>。<br>
        如果请求发生异常，可以利用浏览器的开发者控制台追踪网络请求的流程以debug。<br>
        根据需要编辑响应的Headers和Body，接着便可以根据这次测试进行文档的生成。
    </p>
    <br>
    <h3>
        4. 说明与注意事项
    </h3>
    <p>
        HTTP测试功能完全基于JS的<code>fetch</code>网络请求实现。
        <br>
        你可以用它测试线上或者本地测试服务的接口，并且最大程度地模拟前端的请求环境。
        <br>
        需要注意的事情有：
        <ul>
            <li>接口跨域问题</li>
            <li>请求和响应必须为<code>application/json</code>格式，否则无法正常解析</li>
            <li>只支持http和https请求</li>
        </ul>
    </p>
</div>