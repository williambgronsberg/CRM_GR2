<div id="updateModal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
	<div class="modal-content">
		<span class="close" onclick="document.getElementById('updateModal').classList.remove('show')">&times;</span>
		<h2>Oppdater Kunde</h2>
		<form method="POST">
			<input type="hidden" name="update_customer" value="1">
			<input type="hidden" id="update_id" name="id">
			<div class="form-group">
				<input type="text" id="update_name" name="name" placeholder=" " required>
				<label for="update_name" class="floating">Navn</label>
			</div>
			<div class="form-group">
				<input type="text" id="update_address" name="address" placeholder=" " required>
				<label for="update_address" class="floating">Addresse</label>
			</div>
			<div class="form-group">
				<input type="text" id="update_phone_number" name="phone_number" placeholder=" " required>
				<label for="update_phone_number" class="floating">Telefonnummer</label>
			</div>
			<button type="submit" class="btn-submit">Oppdater</button>
			<button type="button" id="updateDeleteBtn" class="btn-delete" onclick="if(confirm('Er du sikker på at du vil slette kunden?')) { window.location.href='delete_customer.php?id=' + document.getElementById('update_id').value; }" style="display: none;">Slett</button>
		</form>
	</div>
</div>