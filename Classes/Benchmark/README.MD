# PHP������--Benchmark
============================
Benchmark�ṩ������PHP�����࣬����ʵ��PHP������ʱ��ϵ��أ������ε��õ�ʱ����Եȡ�
Benchmark����������������ļ����ֱ���Timer.php��Iterate.php��Profiler.php�����������๦����ͬ��ֻ�ǲ��ص㲻ͬ���������ڵ��Դ����ȡ�����ִ��ʱ�䡣

Ŀ¼�ṹ
-------------------
      Iterate.php           Benchmark_Iterate�����ڵ��Ժ�����ƽ��ִ��ʱ�䡣
      Profiler.php          Benchmark_Profiler������ͳ�ƴ���ͺ�����ִ��ʱ���Լ������ĵ��ô�����
      Timer.php             Benchmark_Timer��ԭ����ͨ��microtime������ȡ΢��ʱ���ٱȽ�ǰ������ʱ��ֵ�Ĳ���ͬ��

### ʹ�÷���

1��Benchmark_Timer��
�ڳ�����������Ӧ�Ķϵ㣬�������ϵ���ʱ���Ӷ���ɼ򵥵ĳ�������ܲ��ԡ�
�����ʽ��һ���Ǳ��������ʽ��$timer->display();����һ�����ֶ�var_dump��print_r��ӡ��$timer->getProfiling();

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
���˵����
1��name��ʾ��ע���ƣ����� �������������עstart��stop��ʾ��ʼ�ͽ�����������Զ����ע marker 01 marker 02��
2��time��ʾ��ǰ��΢��ʱ��
3��diff��ʾ��һ����ǵ���ǰ��ǵ�ִ��ʱ�䣬�������������Ҫ��ȡ��ʱ��û�������ľ������ֵ��
4��total��ʾִ�е���ǰ������ʱ��

2��Benchmark_Iterate��
Benchmark_Iterate�����ڵ��Ժ���ִ�е�ƽ��ʱ�䣬��Benchmark_Timer�಻ͬ���ڿ��Զ�ε���ͬһ��������ȡ��ִ��ʱ���ƽ��ֵ��
```php
require_once "Benchmark/Iterate.php";
$bench = new Benchmark_Iterate();
function test($i){
    echo $i;
}
$bench->run(100,"test",10);
var_dump($bench->get());
```
ͨ������test����100�λ�ȡƽ��ִ��ʱ�䡣
���˵����
1��ÿ�����ֱ�ʾÿ�ε��õ�ʱ��
2��mean��ʾ����ִ�е�ƽ��ʱ�䣬���ϵ���100��test������ƽ��ʱ��Ϊ0.000476
3��iterations��ʾ�������õĴ���

3��Benchmark_Profiler��
Benchmark_Profiler������ͳ�ƺ�����ִ�д�����ִ��ʱ��ȡ�
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
Benchmark_Profiler����ʵ�����ܵ�����ʹ�ò����࣬��Ϊ���б�������õĹ��ߣ���xDebuger�ȡ�

### �������
microtime
(PHP 3, PHP 4, PHP 5)

microtime -- ���ص�ǰ Unix ʱ�����΢����
˵��
mixed microtime ( [bool get_as_float] )

microtime() ��ǰ Unix ʱ����Լ�΢����������������֧�� gettimeofday() ϵͳ���õĲ���ϵͳ�¿��á�
�������ʱ������ѡ�������������� "msec sec" �ĸ�ʽ����һ���ַ��������� sec ���� Unix ��Ԫ��0:00:00 January 1, 1970 GMT�������ڵ�������msec ��΢�벿�֡��ַ����������ֶ�������Ϊ��λ���صġ�

��������� get_as_float ����������ֵ�ȼ��� TRUE��microtime() ������һ����������