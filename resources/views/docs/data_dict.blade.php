<div id="data-dict" class="doc" style="display: none">
    <blockquote>
        <h3 style="font-size: 40px">
            数据字典
        </h3>
    </blockquote>
    <h3>
        1. 什么是数据字典？
    </h3>
    <hr>
    <p>
        <b>数据字典</b>是在一个项目中，经常被使用的数据结构，在一个项目文档中，可能有大量的地方返回同一个数据结构。
        <br>
        举个例子，某个项目中对于用户的数据定义如下：
        <pre>
        {
            "id": 用户id(int),
            "name": 用户名(string),
            "sex": 性别(string),
            "age": 年龄(age)
        }
        </pre>
    </p>
    <p>
        这个结构的数据可能出现在大量的请求/响应中，如果自动生成文档，需要重复填写很多遍说明和描述。
    <br>
        因此ApiLeaf将这些重复出现的数据结构单独保存，并在文档中通过相似度解析和自动匹配的方式，将数据结构的描述注入对应的请求/响应对象中，减少文档的编辑成本。
        <br>
        同时也可以为文档的阅读者查询常用数据结构定义提供便利。
    </p>
    <br>
    <h3>
        2. 创建一个数据字典
    </h3>
    <hr>
    <p>
        要在某个项目中使用数据字典和相关功能，首先需要创建一个数据字典。
        <br>
        在文档的查看页面，点击顶部导航栏的<b>数据字典</b>进入对应项目的数据字典预览页面
        <img src="http://cdn.marklux.cn/18-4-22/97620850.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        点击<b>创建新字典</b>，即可进入数据字典的创建页面
        <br>
        {{--<img src="http://cdn.marklux.cn/18-4-22/62256794.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">--}}
        你可以通过手动填写字典各字段名的方式来创建一个数据字典，当然更简单的方法是，选择<b>自动解析</b>，然后将该数据结构的一个JSON对象实例复制进去:
        <img src="http://cdn.marklux.cn/18-4-22/84738587.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        点击<b>解析</b>即可快速得到该字典的字段列表，接下来补全相关内容即可。
        <img src="http://cdn.marklux.cn/18-4-22/24556411.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
    </p>
    <br>
    <h3>
        3. 数据字典自动匹配(实验性功能)
    </h3>
    <hr>
    <p>
        在API文档的请求/响应说明页面，如果有未标注描述的字段，可以通过点击<button class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span></button>按钮，在该项目的数据字典中尝试根据字段名查找该字段最可能对应的数据结构。
        <img src="http://cdn.marklux.cn/18-4-22/20551861.jpg" class="img-responsive" alt="Responsive image" style="max-width: 50vw">
        ApiLeaf将会根据选中字段所在的数据结构，自动和项目数据字典中所有的结构尝试匹配，返回最可能的数据结构定义，同时返回匹配度、加粗所有命中的字段。
        <img src="http://cdn.marklux.cn/18-4-22/55531038.jpg" class="img-responsive" alt="Responsive image" style="max-width: 30vw">
    </p>
    <br>
    <h3>
        4. 说明与注意事项
    </h3>
    <hr>
    <p>
        <ul>
        <li>数据字典目前不支持多级嵌套的数据结构定义，如果需要，请创建多个数据字典</li>
        <li>自动匹配功能的结果仅供参考，字段的具体的定义仍然需要根据具体情况来确定</li>
        <li>*当匹配度小于40%时，强烈不建议参考匹配结果</li>
    </ul>
    </p>
</div>