<div id="add_modal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
    <div class="modal_content">
        <span class="close" onclick="document.getElementById('add_modal').classList.remove('show')">&times;</span>
        <h2>Add Customer</h2>
        <form method="POST">
            <input type="hidden" name="add_customer" value="1">
            <div class="form_group">
                <input type="text" id="name" name="name" placeholder=" " required>
                <label for="name" class="floating">Name</label>
            </div>
            <div class="form_group">
                <input type="text" id="address" name="address" placeholder=" " required>
                <label for="address" class="floating">Address</label>
            </div>
            <div class="form_group">
                <input type="text" id="phone_number" name="phone_number" placeholder=" " required>
                <label for="phone_number" class="floating">Phone Number</label>
            </div>
            <button type="submit" class="btn_submit">Add Customer</button>
        </form>
    </div>
</div>