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
	<title>Loại sản phẩm</title>
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
		<input class="btn btn-light" placeholder="Nhập tìm kiếm" id="search">
		<button class="btn btn-outline-success" id="btnSearch" >Tìm kiếm</button>
	</div>

	
	<table border="4" cellpadding="10" class="table table-hover">

		<tr class="table">
			<td>ID</td>
			<td>Loại sản phẩm</td>
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
			<!-- <li class="page-item"><a class="page-link" href="#">1</a></li> -->
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
				</a>
			</li>
		</ul>
	</nav>

	<?php 
	require 'code/script.php';
	require 'modal/modalProduct.php';
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			var page=1;
			function Load() {
				$.ajax({
					url:'process/loaisanphampro.php',
					type:'get',
					data:{type:"load",page:page},
					success:function (data) {
						$('#data').html(data);
						$("#nav").show();

					}
				})
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
					url:'process/loaisanphampro.php',
					type:'get',
					data:{type:"phantrang",page:page},
					success:function (data) {
					// alert(data);
					$('#pagination').html(data);}
				});
			}

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

			// thêm trên bảng
			$('#btnThem').click(function(){
				$("#btnSuaSp").hide();
				$('#modalAE').modal('show');
				$("#btnThemSp").show();
				$("#lb").hide();
				$("#id").hide();
				$("#ten").val("");
			})

		// thêm trong modal
		$('#btnThemSp').click(function(){
			var	ten=$("#ten").val();
			$.ajax({
				url:'process/loaisanphampro.php',
				type:'get',
				data:{
					type:"them",
					ten:ten
				},

				success:function(data) {
					Load();
					$('#modalAE').modal('hide');
					alert('Thêm thành công');
				}
			})
		})
		
		$(document).on('click','#btnXoaSp',function(){
			$('#modalDel').modal('show');
			var id=$(this).data("id");
			$('#idXoa').val(id).hide();
		})

		$('#btnXoa').click(function(){	
			var id=$('#idXoa').val();
			$.ajax({
				url:'process/loaisanphampro.php',
				type:'get',
				data:{type:"xoa",id:id},
				success:function(data){
					Load();
					$('#modalDel').modal('hide');
					alert("Xóa thành công");
				}
			})
		})

		$(document).on('click','#btnSua',function(){
			$("#btnThemSp").hide();
			$('#modalAE').modal('show');
			$("#btnSuaSp").show();
			$("#lb").show();
			$("#id").show();
			var id=$(this).data("id");
			$.ajax({
				url:'process/loaisanphampro.php',
				type:'get',
				data:{type:'getid',id:id},
				success:function(data){
						// alert(data);
						data= JSON.parse(data);
						$('.coupled.modal').modal({allowMUltiple: false});
						$('.first.modal').modal('setting','closable', false).modal('show');
						$('#id').val(data["id"]);
						$("#ten").val(data["ten"]);

					}
				})

			// nút đóng trong modal
			$('#btnClose').click(function(){
				$('#modalAE').modal('hide');
			})

		// sửa trong modal
		$('#btnSuaSp').click(function(){
			var id=$("#id").val();
			var	ten=$("#ten").val();
			$.ajax({
				url:'process/loaisanphampro.php',
				type:'get',
				data:{type:"sua",
				id:id,
				ten:ten

			},
			success:function(data) {
				Load();
				$('#modalAE').modal('hide');;
				alert("Sửa thành công");
			}
		})
		})


		
	})	
	})


</script>
</body>
</html>