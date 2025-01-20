<div id="customModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <!-- Alert Section -->
                    <div id="alertMessage" class="alert alert-primary" role="alert" style="display: none;"></div>

                    <form id="userForm" action="{{ route('user.store') }}" method="POST">
                        @csrf <!-- CSRF token for security -->
                        <div class="form-group">
                            <label for="exampleInputName" class="text-light">Name</label>
                            <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail" class="text-light">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword" class="text-light">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="text-light">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                            <small id="emailHelp" class="form-text text-muted">Please remind the user to change the password after registration.</small>
                        </div>
                        <div class="form-group">
                            <label for="role" class="text-light">User Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Admin">Superuser</option>
                                <option value="Client">IT Officer</option>
                                <option value="Admin">IT Manager</option>
                                <option value="Client">Users</option>
                                <option value="Admin">Superordinate</option>
                            </select>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.8); /* Dark background with opacity */
        opacity: 0; /* Start hidden */
        transition: opacity 0.3s ease; /* Transition for fade effect */
    }

    .modal.show {
        display: block; /* Show modal */
        opacity: 1; /* Fully visible */
    }

    .modal-content {
        background-color: transparent; /* Transparent */
        margin: 100px auto; /* Center the modal */
        padding: 20px;
        border: none; /* Remove border */
        width: 50%; /* Adjust width as needed */
        max-width: 500px; /* Max width for larger screens */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow */
        border-radius: 8px; /* Rounded corners */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        background: none;
        border: none;
    }

    .close:hover,
    .close:focus {
        color: white;
        text-decoration: none;
    }

    .button-container {
        margin-top: 10px;
        display: flex;
        flex-direction: row-reverse;
        gap: 10px;
    }

    .form-group label {
        color: #fff; /* White text for labels */
    }

    /* Alert Animation */
    .alert {
        opacity: 0; /* Start hidden */
        transition: opacity 0.5s ease; /* Transition for fade effect */
    }

    .alert.show {
        opacity: 1; /* Fully visible */
    }
</style>

<script>
    function closeModal() {
        const modal = document.getElementById('customModal');
        modal.classList.remove('show'); // Remove the show class
        setTimeout(() => {
            modal.style.display = 'none'; // Hide the modal after the transition
        }, 300); // Match the duration of the transition
    }

    function openModal() {
        const modal = document.getElementById('customModal');
        modal.style.display = 'block'; // Show the modal
        setTimeout(() => {
            modal.classList.add('show'); // Add the show class to trigger the transition
        }, 10); // Small timeout to ensure the display block is applied first
    }

    // Function to log form values
    function logFormValues() {
        const name = document.getElementById('exampleInputName').value;
        const email = document.getElementById('exampleInputEmail').value;
        const password = document.getElementById('exampleInputPassword').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const role = document.getElementById('role').value;

        console.log('Form Values:');
        console.log('Name:', name);
        console.log('Email:', email);
        console.log('Password:', password);
        console.log('Password Confirmation:', passwordConfirmation);
        console.log('Role:', role);
    }

    // Add event listeners to log values in real-time
    document.getElementById('exampleInputName').addEventListener('input', logFormValues);
    document.getElementById('exampleInputEmail').addEventListener('input', logFormValues);
    document.getElementById('exampleInputPassword').addEventListener('input', logFormValues);
    document.getElementById('password_confirmation').addEventListener('input', logFormValues);
    document.getElementById('role').addEventListener('change', logFormValues);

    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        const name = document.getElementById('exampleInputName').value;
        const password = document.getElementById('exampleInputPassword').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const alertMessage = document.getElementById('alertMessage');

        // Clear previous alert message
        alertMessage.style.display = 'none';
        alertMessage.innerHTML = '';

        // Validate Name
        if (name.length < 8 || name.length > 100) {
            alertMessage.style.display = 'block';
            alertMessage.className = 'alert alert-danger show'; // Change to danger alert and show
            alertMessage.innerHTML = 'Name must be between 8 and 100 characters.';
            return;
        }

        // Validate Password
        if (password.length < 8) {
            alertMessage.style.display = 'block';
            alertMessage.className = 'alert alert-danger show'; // Change to danger alert and show
            alertMessage.innerHTML = 'Password must be at least 8 characters long.';
            return;
        }

        // Validate Password Confirmation
        if (password !== passwordConfirmation) {
            alertMessage.style.display = 'block';
            alertMessage.className = 'alert alert-danger show'; // Change to danger alert and show
            alertMessage.innerHTML = 'Passwords do not match.';
            return;
        }

        // Log the values before submission
        console.log('Submitting form with values:', {
            name: name,
            email: document.getElementById('exampleInputEmail').value,
            password: password,
            role: document.getElementById('role').value
        });

        // If all validations pass, submit the form
        this.submit();
    });
</script>
