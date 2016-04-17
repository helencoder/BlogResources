# Simple HTML DOM -- PHP操作HTML DOM对象
============================
A HTML DOM parser written in PHP5+ let you manipulate HTML in a very easy way!
Description, Requirement & Features
1 A HTML DOM parser written in PHP5+ let you manipulate HTML in a very easy way!
2 Require PHP 5+.
3 Supports invalid HTML.
4 Find tags on an HTML page with selectors just like jQuery.
5 Extract contents from HTML in a single line.

Simple HTML DOM 可以让你如同JavaScript一样方便的操作HTML的DOM对象，对于查找其中的元素具有很好的效果。

目录结构
-------------------
      app/                  Simple HTML DOM 相关展示文件
      example/              Simple HTML DOM 相关模板文件
      manual/               Simple HTML DOM 展示页面
      testcase/             Simple HTML DOM 测试案列

### 使用方法

###1 How to get HTML elements

```php
// Create DOM from URL or file
$html = file_get_html('http://www.google.com/');

// Find all images
foreach($html->find('img') as $element)
       echo $element->src . '<br>';

// Find all links
foreach($html->find('a') as $element)
       echo $element->href . '<br>';
```

###2 How to modify HTML elements

```php
// Create DOM from string
$html = str_get_html('<div id="hello">Hello</div><div id="world">World</div>');

$html->find('div', 1)->class = 'bar';

$html->find('div[id=hello]', 0)->innertext = 'foo';

echo $html; // Output: <div id="hello">foo</div><div id="world" class="bar">World</div>
```

###3 Extract contents from HTML

```php
// Dump contents (without tags) from HTML
echo file_get_html('http://www.google.com/')->plaintext;
```

###4 Scraping Slashdot!

```php
// Create DOM from URL
$html = file_get_html('http://slashdot.org/');

// Find all article blocks
foreach($html->find('div.article') as $article) {
    $item['title']     = $article->find('div.title', 0)->plaintext;
    $item['intro']    = $article->find('div.intro', 0)->plaintext;
    $item['details'] = $article->find('div.details', 0)->plaintext;
    $articles[] = $item;
}

print_r($articles)
```

注：使用Simple HTML DOM处理完毕的HTML页面的保存操作.
```php
$html = str_get_html($content);
foreach ($html->find('img') as $element) {
    //处理
    $element->src = '';
}

$wx_content = $html->save();
$html->clear();
```


### 相关资料
