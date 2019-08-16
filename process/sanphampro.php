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

		case "search":
		search();
		break;

		case "getid":
		$id=$_GET['id'];
		renderid($id);
		break;

		case "tenloai":
		getTenLoai();
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




function xoa(){
	require "../mySQL.php";
	$id=$_GET['id'];
	$query="DELETE FROM sanpham WHERE id=$id";
	$statement=$conn->prepare($query);
	$statement->execute();
	$count=$statement->rowCount();
	echo $count;
}
function Load()
{
	$page=$_GET['page'];
	$pos=($page-1)*5;
	require "../mySQL.php";
	$query="SELECT * FROM sanpham ORDER BY id desc LIMIT $pos,5";
	$statement=$conn->prepare($query);
	$statement->execute();
	$data = $statement->fetchAll();
	$i=$pos+1;
	foreach ($data as $obj) {
		echo '<tr class="table">';
		echo '<td>'.($i++).'</td>';
		// echo '<td>'.$obj["id"].'</td>';
		echo '<td>'.$obj["tensp"].'</td>';
		echo '<td>'.number_format($obj["giacu"]).'</td>';
		echo '<td>'.number_format($obj["giamoi"]).'</td>';
		echo '<td>'.$obj["soluong"].'</td>';
		echo '<td>'.Ngay($obj["ngaynhap"]).'</td>';
		echo '<td>'.TinhTrang($obj["tinhtrang"]).'</td>';
		echo '<td>'.TrangThai($obj["trangthai"]).'</td>';
		echo '<td>'.TenLoaiSP($obj["idloaisp"]).'</td>';
		echo '<td class="text-center">
		<button type="button" class="btn btn-success" id="btnSua" data-id="'.$obj["id"].'">Sửa</button>
		<button type="button" class="btn btn-danger" id="btnXoaSP" data-id="'.$obj["id"].'">Xóa</button></td>';
		echo '</tr>';
	};
	
};

function search()
{
	$search=$_GET['search'];
	require "../mySQL.php";
	$statement=$conn->prepare("SELECT * FROM sanpham
	WHERE tensp LIKE '%$search%' or giacu LIKE '%$search%' or giamoi LIKE '%$search%' or soluong LIKE '%$search%' or ngaynhap LIKE '%$search%' or tinhtrang LIKE '%$search%' or trangthai LIKE '%$search%' or idloaisp LIKE '%$search%'");
	$statement->execute();
	$data = $statement->fetchAll();
	$i=1;
	foreach ($data as $obj) {
		echo '<tr class="table">';
		echo '<td>'.($i++).'</td>';
		// echo '<td>'.$obj["id"].'</td>';
		echo '<td>'.$obj["tensp"].'</td>';
		echo '<td>'.number_format($obj["giacu"]).'</td>';
		echo '<td>'.number_format($obj["giamoi"]).'</td>';
		echo '<td>'.$obj["soluong"].'</td>';
		echo '<td>'.Ngay($obj["ngaynhap"]).'</td>';
		echo '<td>'.TinhTrang($obj["tinhtrang"]).'</td>';
		echo '<td>'.TrangThai($obj["trangthai"]).'</td>';
		echo '<td>'.TenLoaiSP($obj["idloaisp"]).'</td>';
		echo '<td class="text-center">
		<button type="button" class="btn btn-success" id="btnSua" data-id="'.$obj["id"].'">Sửa</button>
		<button type="button" class="btn btn-danger" id="btnXoaSP" data-id="'.$obj["id"].'">Xóa</button></td>';
		echo '</tr>';
	};
	
};

// hiện ngày trên table 20190801 -> 01/08/2019
function Ngay($date){
	$dateStr=$date."";
	$nam= substr($dateStr, 0,4);
	$thang=substr($date, 4,2);
	$ngay=substr($date, 6,2);
	$thoigian=$ngay."/".$thang."/".$nam;
	return $thoigian;
}
// hiện ngày trên table 2018-07-22 -> 20180722 "-",""
function NgayInt($dateStr){
	return (int)str_replace("-","",$dateStr);
}

function TenLoaiSP($id){
	require "../mySQL.php";
	$query="SELECT ten FROM loaisp WHERE id=".$id;
	$statement=$conn->prepare($query);
	$statement->execute();
	$rs=$statement->fetchAll();
	return $rs[0][0];
}

//lấy tên loại
function getTenLoai()
{
	require "../mySQL.php";
	$query="SELECT * FROM loaisp ";
	$statement=$conn->prepare($query);
	$statement->execute();
	$rs=$statement->fetchAll();
	foreach ($rs as $row) {
		echo '<option value="'.$row['id'].'">'.$row['ten'].'</option>';
	}
}

// tính trạng
function TinhTrang($tt)
{
	if($tt==0){
		return "default";
	}else if ($tt==1){
		return "new";
	}else{
		return "hot";
	}
}

//trạng thái
function TrangThai($tt)
{
	if($tt==0){
		return "ẩn";
	}else{
		return "hiện";
	}
}

// thêm sp
function them()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("INSERT INTO sanpham (tensp,giacu,giamoi,soluong,ngaynhap,tinhtrang,trangthai,idloaisp) VALUES (:tensp,:giacu,:giamoi,:soluong,:ngaynhap,:tinhtrang,:trangthai,:idloaisp)");
	$statement->execute(
		array(
			':tensp'=>$_GET['tensp'],
			':giacu'=>$_GET['giacu'],
			':giamoi'=>$_GET['giamoi'],
			':soluong'=>$_GET['soluong'],
			':ngaynhap'=>NgayInt($_GET['ngaynhap']) ,
			':tinhtrang'=>$_GET['tinhtrang'],
			':trangthai'=>(bool)$_GET['trangthai'],
			':idloaisp'=>(int)$_GET['idloaisp']
		)
	);
}

//sửa sp
function sua()
{	
	require "../mySQL.php";
	$statement = $conn->prepare("UPDATE sanpham SET tensp=:tensp, giacu=:giacu, giamoi=:giamoi, soluong=:soluong, ngaynhap=:ngaynhap, tinhtrang=:tinhtrang, trangthai=:trangthai, idloaisp =:idloaisp WHERE id=:id");
	$statement->execute(
		array(
			':id'=>$_GET['id'],
			':tensp'=>$_GET['tensp'],
			':giacu'=>$_GET['giacu'],
			':giamoi'=>$_GET['giamoi'],
			':soluong'=>$_GET['soluong'],
			':ngaynhap'=>NgayInt($_GET['ngaynhap']),
			':tinhtrang'=>$_GET['tinhtrang'],
			':trangthai'=>(bool)$_GET['trangthai'],
			':idloaisp'=>(int)$_GET['idloaisp']
		)

	);
}


function renderid($id)
{
	require "../mySQL.php";
	$statement = $conn->prepare("SELECT * FROM sanpham WHERE id=:id");
	$statement->execute(["id"=>$id]);
	$result=$statement->fetch(PDO::FETCH_ASSOC);
	$count=$statement->rowCount();
	if ($count>0) {
		echo json_encode($result);	
	}
	
}
function SoHang(){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM sanpham");
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}

?>