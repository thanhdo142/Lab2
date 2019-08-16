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

		case "sua":
		sua();
		break;

		case "xoa":
		xoa();
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
	$query="SELECT * FROM loaisp ORDER BY id desc LIMIT $pos,5";
	$statement=$conn->prepare($query);
	$statement->execute();
	$data = $statement->fetchAll();
	$i=$pos+1;
	foreach ($data as $obj) {
		echo '<tr class="table">';
		// echo '<td>'.$obj["id"].'</td>';
		echo '<td>'.($i++).'</td>';
		echo '<td>'.$obj["ten"].'</td>';
		echo '<td class="text-center">
		<button type="button" class="btn btn-success" id="btnSua" data-id="'.$obj["id"].'">Sửa</button>
		<button type="button" class="btn btn-danger" id="btnXoaSp" data-id="'.$obj["id"].'">Xóa</button></td>';
		echo '</tr>';
	};
};



// thêm loại sp
function them()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("INSERT INTO loaisp (ten) VALUES (:ten)");
	$statement->execute(
		array(
			':ten'=>$_GET['ten']
		)
	);
}

//sửa loại sp
function sua()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("UPDATE loaisp SET ten=:ten WHERE id=:id");
	$statement->execute(
		array(
			':id'=>$_GET['id'],
			':ten'=>$_GET['ten']
		)
	);
}

// xóa loại sp
function xoa(){
	require "../mySQL.php";
	$id=$_GET['id'];
	$query="DELETE FROM loaisp WHERE id=$id";
	$statement=$conn->prepare($query);
	$statement->execute();
	$count=$statement->rowCount();
	echo $count;
}


function renderid($id)
{
	require "../mySQL.php";
	$statement = $conn->prepare("SELECT * FROM loaisp WHERE id=:id");
	$statement->execute(["id"=>$id]);
	$result=$statement->fetch(PDO::FETCH_ASSOC);
	$count=$statement->rowCount();
	if ($count>0) {
		echo json_encode($result);	
	}
	
}

function SoHang(){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM loaisp");
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}
?>