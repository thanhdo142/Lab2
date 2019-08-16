<div class="modal" id="modalAE">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" >Người dùng</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">

				<label id="lb">ID</label><br>
				<input type="text" class="form-control" id="id" readonly>

				<label>User name</label><br>
				<input type="text" class="form-control" id="username">

				<label>PassWord</label><br>
				<input type="text" class="form-control" id="password">

				<label>Role</label><br>
				<select class="form-control" id="role">
					<option selected value="1">Member</option>
					<option value="2">Admin</option>
				</select>
				
			</div>
			<div class="modal-body">
				<input type="button" value="Thêm" class="btn btn-success" class="form-control" id="btnThemUs" >
				<input type="button" value="Sửa" class="btn btn-warning" class="form-control" id="btnSuaUs">
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
        <h5 class="modal-title">Xóa người dùng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bạn có muốn xóa người dùng không ?</p>
        <input type="text" id="idXoa">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" class="form-control" id="btnXoa">Xóa</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" class="form-control">Close</button>
      </div>
    </div>
  </div>
</div>