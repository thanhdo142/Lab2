<div class="modal" id="modalAE">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" >Loại sản phẩm</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">

				<label id="lb">ID</label><br>
				<input type="text" class="form-control" id="id" readonly>

				<label>Loại sản phẩm</label><br>
				<input type="text" class="form-control" id="ten">
				
			</div>
			<div class="modal-body">
				<input type="button" value="Thêm" class="btn btn-success" class="form-control" id="btnThemSp" >
				<input type="button" value="Sửa" class="btn btn-warning" class="form-control" id="btnSuaSp">
				<input type="button" value="Đóng" class="btn btn-danger" class="form-control" id="btnClose">
			</div>

		</div>
	</div>
</div>


<!-- modal xóa -->
<div class="modal" tabindex="-1" role="dialog" id="modalDel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Xóa loại sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bạn có muốn xóa loại sản phẩm không ?</p>
        <input type="text" id="idXoa">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" class="form-control" id="btnXoa">Xóa</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" class="form-control">Close</button>
      </div>
    </div>
  </div>
</div>