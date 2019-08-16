<?php 
if (isset($_GET['type'])) {
	$type=$_GET['type'];
	switch ($type) {
		case "load":
		Load();
		break;
		
		case "them":
		them();
		break;

		case "ktra":
		// ktraUser();	
		break;

		case "sua":
		sua();
		break;

		case "xoa":
		xoa();
		break;

		case "search":
		search();
		break;

		case "getid":
		$id=$_GET['id'];
		renderid($id);
		break;


		case "phantrang":
		$page=$_GET['page'];
		$trang=ceil(SoHang()/5);
		// echo $trang;
		echo '			<li class="page-item '.($page==1?"disabled":"active").'">
		<a class="page-link prev" aria-label="Previous">
		<span aria-hidden="true">&laquo;</span>
		<span class="sr-only">Previous</span>
		</a>
		</li>';
		for($i=1;$i<=$trang;$i++)
		{

			echo '<li class="page-item '.($i==$page?"active":"").'"><a class="page-link pg">'.$i.'</a></li>';
		}	
		echo '			<li class="page-item '.($page==$trang?"disabled":"active").'">
		<a class="page-link next" aria-label="Next">
		<span aria-hidden="true">&raquo;</span>
		<span class="sr-only">Next</span>
		</a>
		</li>';
		break;

		default:
			// code...
		break;
	}
}

//load dữ liệu
function Load()
{
	$page=$_GET['page'];
	$pos=($page-1)*5;
	require "../mySQL.php";
	$query="SELECT * FROM nguoidung ORDER BY id desc LIMIT $pos,5";
	$statement=$conn->prepare($query);
	$statement->execute();
	$data = $statement->fetchAll();
	$i=$pos+1;
	foreach ($data as $obj) {
		echo '<tr class="table">';
		// echo '<td>'.$obj["id"].'</td>';
		echo '<td>'.($i++).'</td>';
		echo '<td>'.$obj["username"].'</td>';
		echo '<td>'.$obj["password"].'</td>';
		echo '<td>'.Role($obj["role"]).'</td>';
		echo '<td class="text-center">
		<button type="button" class="btn btn-success" id="btnSua" data-id="'.$obj["id"].'">Sửa</button>
		<button type="button" class="btn btn-danger" id="btnXoaUs" data-id="'.$obj["id"].'">Xóa</button></td>';
		echo '</tr>';
	};
};

function search()
{
	$search=$_GET['search'];
	require "../mySQL.php";
	$statement=$conn->prepare("SELECT * FROM nguoidung
	WHERE username LIKE '%$search%' or password LIKE '%$search%' or role LIKE '%$search%'");
	$statement->execute();
	$data = $statement->fetchAll();
	$i=1;
	foreach ($data as $obj) {
		echo '<tr class="table">';
		// echo '<td>'.$obj["id"].'</td>';
		echo '<td>'.($i++).'</td>';
		echo '<td>'.$obj["username"].'</td>';
		echo '<td>'.$obj["password"].'</td>';
		echo '<td>'.Role($obj["role"]).'</td>';
		echo '<td class="text-center">
		<button type="button" class="btn btn-success" id="btnSua" data-id="'.$obj["id"].'">Sửa</button>
		<button type="button" class="btn btn-danger" id="btnXoaUs" data-id="'.$obj["id"].'">Xóa</button></td>';
		echo '</tr>';
	};
	
};

function ktraUser()
{	
	$messenger='';
	require '../mySQL.php';
	$query="SELECT * FROM nguoidung WHERE username = :username";
	$statement=$conn->prepare($query);
	$statement->execute();
	$count=$statement->rowCount();
	if($count > 0)
	{
		// ':username' = $_GET['username'];
		$messenger='<div class="alert alert-warning alert-dismissible fade show" role="alert">
		Tài khoản đã tồn tại. Vui lòng nhập lại!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span></button></div>';
	}else
	{   
		$messenger='<div class="alert alert-success alert-dismissible fade show" role="alert">
		Tài khoản có thể sử dụng!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span></button></div>';
	}
}

// hiển thị admin/menber
function Role($s)
{
	if($s==1){
		return "member";
	}else{
		return "admin";
	}
}

// thêm user
function them()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("INSERT INTO nguoidung (username,password,role) VALUES (:username,:password,:role)");
	$statement->execute(
		array(
			':username'=>$_GET['username'],
			':password'=>$_GET['password'],
			':role'=>$_GET['role']
		)
	);
}

//sửa user
function sua()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("UPDATE nguoidung SET username=:username, password=:password, role=:role WHERE id=:id");
	$statement->execute(
		array(
			':id'=>$_GET['id'],
			':username'=>$_GET['username'],
			':password'=>$_GET['password'],
			':role'=>$_GET['role']
		)
	);
}

// xóa user
function xoa(){
	require "../mySQL.php";
	$id=$_GET['id'];
	$query="DELETE FROM nguoidung WHERE id=$id";
	$statement=$conn->prepare($query);
	$statement->execute();
	$count=$statement->rowCount();
	echo $count;
}


function renderid($id)
{
	require "../mySQL.php";
	$statement = $conn->prepare("SELECT * FROM nguoidung WHERE id=:id");
	$statement->execute(["id"=>$id]);
	$result=$statement->fetch(PDO::FETCH_ASSOC);
	$count=$statement->rowCount();
	if ($count>0) {
		echo json_encode($result);	
	}
	
}

function SoHang(){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM nguoidung");
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}
?>