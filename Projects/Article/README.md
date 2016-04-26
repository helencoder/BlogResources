# 基本博客实现
关注点：基本的PHP语法和HTML的直接结合
示例：
1、使用PHP进行判断语句的写法，控制页面的显示。（article.list.php）
    <div id="content">
	<?php
		if(empty($data)){
			echo "当前没有文章，请管理员在后台添加文章";
		}else{
			foreach($data as $value){
	?>
		<div class="post">
			<h1 class="title"><?php echo $value['title']?><span style="color:#ccc;font-size:14px;">　　作者：<!--作者放置到这里--><?php echo $value['author']?></span></h1>
			<div class="entry">
				<?php echo $value['description']?>
			</div>
			<div class="meta">
				<p class="links"><a href="article.show.php?id=<?php echo $value['id']?>" class="more">查看详细</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;</p>
			</div>
		</div>
	<?php
			}
		}
	?>
	</div>
	在页面最上部进行数据的获取，存入data中。利于下文中的使用
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

2、文件间的相互引用，以及配置的分离
数据库连接：connect.php
<?php
	require_once('config.php');
	//连库
	if(!($con = mysql_connect(HOST, USERNAME, PASSWORD))){
		echo mysql_error();
	}
	//选库
	if(!mysql_select_db('info')){
		echo mysql_error();
	}
	//字符集
	if(!mysql_query('set names utf8')){
		echo mysql_error();
	}
?>
配置文件:config.php
<?php
	header("Content-type: text/html; charset=utf-8");
	define('HOST', '127.0.0.1');
	define('USERNAME', 'root');
	define('PASSWORD', '123');
?>

3、HTML中页面跳转
window.location.href = '';

4、mysql相关函数基本都不再使用了，用mysqli进行相关数据库的连接成为主流。
