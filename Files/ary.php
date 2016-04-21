<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 19:32
 * description: ����ת������
 */

/*
 * һ��ʮ���ƣ�decimal system��ת������˵��
1��ʮ����ת������ decbin() ����������ʵ��

echo decbin(12); //��� 1100
echo decbin(26); //��� 11010
decbin
(PHP 3, PHP 4, PHP 5)
decbin -- ʮ����ת��Ϊ������
˵��
string decbin ( int number )
����һ�ַ����������и��� number �����Ķ����Ʊ�ʾ������ת���������ֵΪʮ���Ƶ� 4294967295������Ϊ 32 �� 1 ���ַ�����

2��ʮ����ת�˽��� decoct() ����

echo decoct(15); //��� 17
echo decoct(264); //��� 410
decoct
(PHP 3, PHP 4, PHP 5)
decoct -- ʮ����ת��Ϊ�˽���
˵��
string decoct ( int number )
����һ�ַ����������и��� number �����İ˽��Ʊ�ʾ������ת���������ֵΪʮ���Ƶ� 4294967295������Ϊ "37777777777"��

3��ʮ����תʮ������ dechex() ����

echo dechex(10); //��� a
echo dechex(47); //��� 2f
dechex
(PHP 3, PHP 4, PHP 5)
dechex -- ʮ����ת��Ϊʮ������
˵��
string dechex ( int number )
����һ�ַ����������и��� number ������ʮ�����Ʊ�ʾ������ת���������ֵΪʮ���Ƶ� 4294967295������Ϊ "ffffffff"��

���������ƣ�binary system��ת������˵��
1��������תʮ���ƽ� bin2hex() ����

$binary = "11111001";
$hex = dechex(bindec($binary));
echo $hex;//���f9
bin2hex
(PHP 3 >= 3.0.9, PHP 4, PHP 5)
bin2hex -- ������������ת����ʮ�����Ʊ�ʾ
˵��
string bin2hex ( string str )
���� ASCII �ַ�����Ϊ���� str ��ʮ�����Ʊ�ʾ��ת��ʹ���ֽڷ�ʽ������λ�ֽ����ȡ�

2��������תʮ�ƽ� bindec() ����

echo bindec('110011'); //��� 51
echo bindec('000110011'); //��� 51
echo bindec('111'); //��� 7
bindec
(PHP 3, PHP 4, PHP 5)
bindec -- ������ת��Ϊʮ����
˵��
number bindec ( string binary_string )
���� binary_string ��������ʾ�Ķ���������ʮ���Ƶȼ�ֵ��
bindec() ��һ����������ת���� integer����ת����������Ϊ 31 λ 1 ����˵ʮ���Ƶ� 2147483647��PHP 4.1.0 ��ʼ���ú������Դ������ֵ����������£����᷵�� float ���͡�

�����˽��ƣ�octal system��ת������˵��
�˽���תʮ���� octdec() ����

echo octdec('77'); //��� 63
echo octdec(decoct(45)); //��� 45
octdec
(PHP 3, PHP 4, PHP 5)
octdec -- �˽���ת��Ϊʮ����
˵��
number octdec ( string octal_string )
���� octal_string ��������ʾ�İ˽�������ʮ���Ƶ�ֵ����ת����������ֵΪ 17777777777 ��ʮ���Ƶ� 2147483647��PHP 4.1.0 ��ʼ���ú������Դ�������֣���������£����᷵�� float ���͡�

�ģ�ʮ�����ƣ�hexadecimal��ת������˵��
ʮ������תʮ���� hexdec()����

var_dump(hexdec("See"));
var_dump(hexdec("ee"));
// both print "int(238)"

var_dump(hexdec("that")); // print "int(10)"
var_dump(hexdec("a0")); // print "int(160)"
hexdec
(PHP 3, PHP 4, PHP 5)
hexdec -- ʮ������ת��Ϊʮ����
˵��
number hexdec ( string hex_string )
������ hex_string ��������ʾ��ʮ����������ֵ�ĵ�ʮ��������hexdec() ��һ��ʮ�������ַ���ת��Ϊʮ������������ת���������ֵΪ 7fffffff����ʮ���Ƶ� 2147483647��PHP 4.1.0 ��ʼ���ú������Դ�������֣���������£����᷵�� float ���͡�
hexdec() �����������з�ʮ�������ַ��滻�� 0��������������ߵ��㶼�����ԣ����ұߵ�������ֵ�С�

�壬�������ת�� base_convert() ����

$hexadecimal = 'A37334';
echo base_convert($hexadecimal, 16, 2);//��� 101000110111001100110100
base_convert
(PHP 3 >= 3.0.6, PHP 4, PHP 5)

base_convert -- ���������֮��ת������
˵��
string base_convert ( string number, int frombase, int tobase )
����һ�ַ��������� number �� tobase ���Ƶı�ʾ��number ����Ľ����� frombase ָ����frombase �� tobase ��ֻ���� 2 �� 36 ֮�䣨���� 2 �� 36��������ʮ���Ƶ���������ĸ a-z ��ʾ������ a ��ʾ 10��b ��ʾ 11 �Լ� z ��ʾ 35��

 * */