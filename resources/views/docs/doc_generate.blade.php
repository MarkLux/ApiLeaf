<div id="doc-generate" class="doc" style="display: none">
    <blockquote>
        <h3 style="font-size: 40px">
            自动文档生成
        </h3>
    </blockquote>
    <h3>
        1. 基于接口测试生成文档
    </h3>
    <hr>
    <p>
        *在你生成一个文档前，首先需要创建一个项目，可以参考<a onclick="activeDoc('doc-manage')">文档管理</a>的第一部分了解如何创建一个项目。
        <br>
        ApiLeaf 完全基于HTTP测试时请求和响应的结构来生成文档，在完成一次HTTP测试后点击最下方的<b>生成文档</b>即可进入文档编辑界面。
    </p>
    <br>
    <h3>
        2. 编辑文档内容
    </h3>
    <hr>
    <p>
        进入文档编辑页面后，首先填写该API的基本信息，包括：
        <ul>
        <li>API所属的项目名<code>COLLECTION</code>，可从已创建和参与的项目中选择</li>
        <li>API的名称<code>NAME</code>，注意该名称在项目中必须唯一</li>
        <li>API的请求地址<code>URL</code>，会自动填入测试时使用的URL</li>
        <li>API的请求方法<code>METHOD</code>，会自动填入测试时使用的方法</li>
        <li>API的说明<code>DESCRIPTION</code>，可以不填写</li>
        </ul>
        如下图：
    <img src="http://of1deuret.bkt.clouddn.com/18-4-22/6599911.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
    </p>
    <p>
        接下来需要填写API的请求和响应结构信息，分为以下几部分：
        <ul>
            <li>请求头<code>Request-Headers</code></li>
            <li>请求参数<code>QueryString</code></li>
            <li>请求体<code>Request-Body</code></li>
            <li>请求示范<code>Request-Example</code></li>
            <li>响应头<code>Response-Headers</code></li>
            <li>响应体<code>Response-Body</code></li>
            <li>响应示范<code>Request-Example</code></li>
        </ul>
    各个部分（除示范外）每一个字段在文档中需要给出3个说明：字段名<code>key</code>、字段类型<code>type</code>和字段说明<code>description</code><br>
    每部分需要填写的内容都以<b>JSON</b>的形式编辑，测试完成后会自动生成字段名和字段类型，你只需要补充和修改对应的JSON即可，以响应体为例：
    <img src="http://of1deuret.bkt.clouddn.com/18-4-22/6628827.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
    只需要检查每个字段的<code>body_type</code>是否正确，并根据需要补充<code>body_description</code>即可。
    </p>
    <br>
    <h3>
        3. 选择内容并生成文档
    </h3>
    <hr>
    <p>
        你不必填写结构信息的所有部分，只需要补充完成需要给对接人员展示的部分即可。
        <br>
        可以在每个部分的面板头部勾选/取消勾选来选中/取消选中对应的部分。
        <img src="http://of1deuret.bkt.clouddn.com/18-4-22/86505763.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        最终生成的文档只会包含你所选中的部分。
        <br>
        补充好所有需要填写的内容后，点击最下方的<b>生成文档</b>按钮即可正式生成该API的文档，并进入预览界面。
        <img src="http://of1deuret.bkt.clouddn.com/18-4-22/69614079.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        该接口的文档将自动并入选中的项目文档中。
    </p>
    <br>
    <h3>
        4. 说明与注意事项
    </h3>
    <hr>
    <p>
        <ul>
            <li>编辑框中的内容必须是完整的JSON内容，否则可能会产生错误</li>
            <li>不要修改编辑框中提供的各个key</li>
        <li>如果经常出现重复的字段，可以通过创建<a onclick="activeDoc('data-dict')">数据字典</a>的方式减少编辑量</li>
        </ul>
    </p>
</div>