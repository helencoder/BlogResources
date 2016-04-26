# PHP测试类--Benchmark
============================
Benchmark提供了三个PHP操作类，可以实现PHP程序中时间断点监控，程序多次调用的时间测试等。
Benchmark工具类包共有三个文件，分别是Timer.php、Iterate.php和Profiler.php，三个工具类功能相同，只是侧重点不同，都是用于调试代码获取程序的执行时间。

目录结构
-------------------
      Iterate.php           Benchmark_Iterate类用于调试函数的平均执行时间。
      Profiler.php          Benchmark_Profiler类用于统计代码和函数的执行时间以及函数的调用次数。
      Timer.php             Benchmark_Timer类原理与通过microtime函数获取微秒时间再比较前后两个时间值的差相同。

### 使用方法

1、Benchmark_Timer类
在程序中设置相应的断点，最后输出断点间的时间差，从而完成简单的程序的性能测试。
输出方式：一种是表格输出方式，$timer->display();另外一种是手动var_dump或print_r打印，$timer->getProfiling();

```php
require_once 'Benchmark/Timer.php';
$timer = new Benchmark_Timer();
$timer->start();
$timer->setMarker("marker 01");
usleep(1);
$timer->setMarker("marker 02");
usleep(2);
$timer->setMarker("marker 03");
usleep(3);
$timer->stop();
$timer->display();
```
结果说明：
1，name表示标注名称，如上 包含两个特殊标注start和stop表示开始和结束，其次是自定义标注 marker 01 marker 02等
2，time表示当前的微秒时间
3，diff表示上一个标记到当前标记的执行时间，这个就是我们需要获取的时间差，没错，看的就是这个值。
4，total表示执行到当前的整个时间

2、Benchmark_Iterate类
Benchmark_Iterate类用于调试函数执行的平均时间，与Benchmark_Timer类不同在于可以多次调用同一个函数获取其执行时间的平均值。
```php
require_once "Benchmark/Iterate.php";
$bench = new Benchmark_Iterate();
function test($i){
    echo $i;
}
$bench->run(100,"test",10);
var_dump($bench->get());
```
通过调用test函数100次获取平均执行时间。
结果说明：
1，每个数字表示每次调用的时间
2，mean表示函数执行的平均时间，如上调用100次test函数的平均时间为0.000476
3，iterations表示函数调用的次数

3、Benchmark_Profiler类
Benchmark_Profiler类用于统计函数的执行次数和执行时间等。
```php
require_once 'Benchmark/Profiler.php';
$profiler = new Benchmark_Profiler(TRUE);
function myFunction() {
    global $profiler;
    $profiler->enterSection('myFunction');     //do something
    $profiler->leaveSection('myFunction');
    return;
    }//do something
myFunction();//do more
```
Benchmark_Profiler类在实际性能调试中使用并不多，因为还有比这个更好的工具，如xDebuger等。

### 相关资料
microtime
(PHP 3, PHP 4, PHP 5)

microtime -- 返回当前 Unix 时间戳和微秒数
说明
mixed microtime ( [bool get_as_float] )

microtime() 当前 Unix 时间戳以及微秒数。本函数仅在支持 gettimeofday() 系统调用的操作系统下可用。
如果调用时不带可选参数，本函数以 "msec sec" 的格式返回一个字符串，其中 sec 是自 Unix 纪元（0:00:00 January 1, 1970 GMT）起到现在的秒数，msec 是微秒部分。字符串的两部分都是以秒为单位返回的。

如果给出了 get_as_float 参数并且其值等价于 TRUE，microtime() 将返回一个浮点数。
