<div id="update_modal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
	<div class="modal_content">
		<span class="close" onclick="document.getElementById('update_modal').classList.remove('show')">&times;</span>
		<h2>Update Customer</h2>
		<form method="POST">
			<input type="hidden" name="update_customer" value="1">
			<input type="hidden" id="update_id" name="id">
			<div class="form_group">
				<input type="text" id="update_name" name="name" placeholder=" " required>
				<label for="update_name" class="floating">Name</label>
			</div>
			<div class="form_group">
				<input type="text" id="update_address" name="address" placeholder=" " required>
				<label for="update_address" class="floating">Address</label>
			</div>
			<div class="form_group">
				<input type="text" id="update_phone_number" name="phone_number" placeholder=" " required>
				<label for="update_phone_number" class="floating">Phone Number</label>
			</div>
			<button type="submit" class="btn_submit">Update Customer</button>
			<button type="button" id="update_delete_btn" class="btn_delete" onclick="if(confirm('Are you sure you want to delete this customer?')) { window.location.href='delete_customer.php?id=' + document.getElementById('update_id').value; }" style="display: none;">Delete</button>
		</form>
	</div>
</div>