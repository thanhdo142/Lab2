<?php 
session_start();
if(!isset($_SESSION['username'])){
	header('Location:dangnhap.php');
}else{
	if(isset($_SESSION['username']))
	{
		echo'<div class="alert alert-success" role="alert">
		Đăng nhập thành công. Chào '.$_SESSION['username'].' !<a>	</a></div><br>';
	}else{
		header('Location:login.php');
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sản phẩm</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Demo project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require 'code/style.php' ?>
	<style type="text/css"></style>
</head>
<body>
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Menu
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="sanpham.php">Sản phẩm</a>
			<a class="dropdown-item" href="nguoidung.php">Người dùng</a>
			<a class="dropdown-item" href="loaisanpham.php">Loại sản phẩm</a>
		</div>
	</div>
	
	<!-- form tìm kiếm -->
	<div class="form-group mx-sm-3 mb-2 ">
		<input class="btn btn-light " placeholder="Nhập tìm kiếm" id="search">

		<button class="btn btn-outline-success" id="btnSearch" >Tìm kiếm</button>
	</div>

	<table border="4" cellpadding="10" class="table table-hover">

		<tr class="table sort">
			<!-- <td>ID</td> -->
			<td>STT</td>

			<td class="sr">Tên sản phẩm</i></td>
			<td class="sr">Giá cũ</td>
			<td class="sr">Giá mới</td>
			<td class="sr">Số lượng</td>
			<td class="sr">Ngày nhập</td>
			<td class="sr">Tình trạng</td>
			<td class="sr">Trạng thái</td>
			<td class="sr">Loại sản phẩm</td>
			<td class="text-center"><button class="btn btn-primary" id="btnThem">Thêm</button></td>
		</tr>
		<tbody id="data">

		</tbody>
	</table>
	<nav aria-label="Page navigation example" id="nav">
		<ul class="pagination justify-content-end" id="pagination">
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Previous</span>
				</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
				</a>
			</li>
		</ul>
	</nav>
	<?php 

	require 'modal/modalSP.php';
	require 'code/script.php';

	?>
	<script type="text/javascript">	

		$(document).ready(function () {
			var page=1;
			function Load(){
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"load",page:page},
					success:function (data) {
						$('#data').html(data);
						$("#nav").show();
					}
				});	
				PhanTrang();			
			}
			Load();

			$(document).on('click','#pagination li .pg',function(){
				var id =$(this).text();
				page=id;
				Load();
			})
			$(document).on('click','#pagination li .prev',function(){
				page--;
				Load();
			})
			$(document).on('click','#pagination li .next',function(){
				page++;
				Load();
			})
			function PhanTrang(){
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"phantrang",page:page},
					success:function (data) {
					// alert(data);
					$('#pagination').html(data);
				}
			});
			}
			var i=0; //0 sắp xếp
			$('.sort td.sr').append('<i class="fa fas fa-sort"></i>');
			$('.sort td.sr').click(function(){
				
				$('i').remove();
				$('.sort td.sr').append('<i class="fa fas fa-sort"></i>').removeAttr("style");

				$(this).find('i').remove();
				$(this).css("color","white").css("background-color","red");
				if (i==0) { // Tăng
					$(this).append('<i class="fa fa-angle-double-up"></i>');
					i++;
				} else if(i==1) { // giam
					$(this).append('<i class="fa fa-angle-double-down"></i>');
					i++;
				}else{ // Bằng
					$(this).append('<i class="fa fas fa-sort"></i>');
					$(this).removeAttr("style");
					i=0;
				}
				console.log(i);
			})

			$('#btnSearch').click(function(){

				var	search=$("#search").val();
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"search",
					search:search
				},
				success:function (data) {
					$("#nav").hide();
					$('#data').html(data);
				}
			})
			})

			//Thêm trên table
			$('#btnThem').click(function(){
				$("#btnSuaSP").hide();
				$('#modalAE').modal('show');
				$("#btnThemSP").show();
				$("#lb").hide();
				$("#id").hide();
				$("#tensp").val("");
				$("#giacu").val("");
				$("#giamoi").val("");
				$("#soluong").val("");
				$("#ngaynhap").val("");
				$("#tinhtrang").val(0);
				$("#trangthai").val(1);
				$("#idloaisp").val("");
			})
			//thêm trong modal
			$('#btnThemSP').click(function(){

				var	tensp=$("#tensp").val();
				var	giacu=$("#giacu").val();
				var	giamoi=$("#giamoi").val();
				var	soluong=$("#soluong").val();
				var	ngaynhap=$("#ngaynhap").val();
				var	tinhtrang=$("#tinhtrang").val();
				var	trangthai=$("#trangthai").val();
				var	idloaisp=$("#idloaisp").val();
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"them",
					tensp:tensp,
					giacu:giacu,
					giamoi:giamoi,
					soluong:soluong,
					ngaynhap:ngaynhap,
					tinhtrang:tinhtrang,
					trangthai:trangthai,
					idloaisp:idloaisp

				},
				success:function(data) {
					// alert(data);
					Load();
					$('#modalAE').modal('hide');
					alert("Thêm thành công");
				}
			})
			})
			//sửa trên table
			$(document).on('click','#btnSua',function(){
				$("#btnThemSP").hide();
				$('#modalAE').modal('show');
				$("#btnSuaSP").show();
				$("#lb").show();
				$("#id").show();
				var id=$(this).data("id");
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:'getid',id:id},
					success:function(data){
						// alert(data);
						data= JSON.parse(data);
						$('.coupled.modal').modal({allowMUltiple: false});
						$('.first.modal').modal('setting','closable', false).modal('show');
						$('#id').val(data["id"]);
						$("#tensp").val(data["tensp"]);
						$("#giacu").val(data["giacu"]);
						$("#giamoi").val(data["giamoi"]);
						$("#soluong").val(data["soluong"]);
						var ngay=Ngay(data["ngaynhap"]);
						$("#ngaynhap").val(ngay);
						$("#tinhtrang").val(data["tinhtrang"]);
						$("#trangthai").val(data["trangthai"]);
						$("#idloaisp").val(data["idloaisp"]);
					}
				})
			})
			// chuyển ngày trên table 20190108 -> 2019-08-01
			function Ngay($date){
				var dateStr=$date+"";
				var nam= dateStr.substr(0,4);
				var thang=dateStr.substr(4,2);
				var ngay=dateStr.substr(6,2);
				var thoigian=nam+"-"+thang+"-"+ngay;
				return thoigian;
			}

			// lấy tên loại sp
			$.ajax({
				url:'process/sanphampro.php',
				type:'get',
				data:{type:"tenloai"},
				success:function(data){
					$('#idloaisp').html(data);
				}
			})

			//lấy số trang
			$.ajax({
				url:'process/sanphampro.php',
				type:'get',
				data:{type:"sotrang"},
				success:function(data){
					$('#phantrang').html(data);
				}
			})

			// $('#phantrang').click(function(){
			// 	$.ajax({
			// 		url:'process/sanphampro.php',
			// 		type:'get',
			// 		data:{type:"phantrang"},
			// 		success:function(data){
			// 			$('#data').html(data);
			// 		}
			// 	})
			// })

			// nút đóng trong modal
			$('#btnClose').click(function(){
				$('#modalAE').modal('hide');
			})

			// sửa trong modal
			$('#btnSuaSP').click(function(){
				var id=$("#id").val();
				var	tensp=$("#tensp").val();
				var	giacu=$("#giacu").val();
				var	giamoi=$("#giamoi").val();
				var	soluong=$("#soluong").val();
				var	ngaynhap=$("#ngaynhap").val();
				var	tinhtrang=$("#tinhtrang").val();
				var	trangthai=$("#trangthai").val();
				var	idloaisp=$("#idloaisp").val();

				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"sua",
					id:id,
					tensp:tensp,
					giacu:giacu,
					giamoi:giamoi,
					soluong:soluong,
					ngaynhap:ngaynhap,
					tinhtrang:tinhtrang,
					trangthai:trangthai,
					idloaisp:idloaisp

				},
				success:function(data) {
					Load();
					$('#modalAE').modal('hide');;
					alert("Sửa thành công");
				}
			})
			})

			// Xóa trên bảng
			$(document).on('click',"#btnXoaSP",function(){
				var id=$(this).data('id');
				$('#modalDel').modal('show');
				$('#idXoa').val(id).hide();
			})

			$('#btnXoa').click(function(){
				var id=$('#idXoa').val();
				$.ajax({
					url:'process/sanphampro.php',
					type:'get',
					data:{type:"xoa",id:id},
					success:function(data){
						Load();
						$('#modalDel').modal('hide');
						alert("Xóa thành công");
					}
				})
			})
		});
	</script>

</body>
</html>