# ��������ʵ��
��ע�㣺������PHP�﷨��HTML��ֱ�ӽ��
ʾ����
1��ʹ��PHP�����ж�����д��������ҳ�����ʾ����article.list.php��
    <div id="content">
	<?php
		if(empty($data)){
			echo "��ǰû�����£������Ա�ں�̨�������";
		}else{
			foreach($data as $value){
	?>
		<div class="post">
			<h1 class="title"><?php echo $value['title']?><span style="color:#ccc;font-size:14px;">�������ߣ�<!--���߷��õ�����--><?php echo $value['author']?></span></h1>
			<div class="entry">
				<?php echo $value['description']?>
			</div>
			<div class="meta">
				<p class="links"><a href="article.show.php?id=<?php echo $value['id']?>" class="more">�鿴��ϸ</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;</p>
			</div>
		</div>
	<?php
			}
		}
	?>
	</div>
	��ҳ�����ϲ��������ݵĻ�ȡ������data�С����������е�ʹ��
	<?php
    	require_once('connect.php');
    	$sql = "select * from article order by dateline desc";
    	$query = mysql_query($sql);
    	if($query&&mysql_num_rows($query)){
    		while($row = mysql_fetch_assoc($query)){
    			$data[] = $row;
    		}
    	}
    ?>

2���ļ�����໥���ã��Լ����õķ���
���ݿ����ӣ�connect.php
<?php
	require_once('config.php');
	//����
	if(!($con = mysql_connect(HOST, USERNAME, PASSWORD))){
		echo mysql_error();
	}
	//ѡ��
	if(!mysql_select_db('info')){
		echo mysql_error();
	}
	//�ַ���
	if(!mysql_query('set names utf8')){
		echo mysql_error();
	}
?>
�����ļ�:config.php
<?php
	header("Content-type: text/html; charset=utf-8");
	define('HOST', '127.0.0.1');
	define('USERNAME', 'root');
	define('PASSWORD', '123');
?>

3��HTML��ҳ����ת
window.location.href = '';

4��mysql��غ�������������ʹ���ˣ���mysqli����������ݿ�����ӳ�Ϊ������
