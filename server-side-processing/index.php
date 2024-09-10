<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Table with DataTables</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS (optional for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Validate.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: burlywood;
            margin-bottom: 30px;
            font-weight: 700;
        }

        /* Styling for the table */
        table.dataTable {
            width: 100%;
            margin: 0 auto;
            background-color: #fff;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table.dataTable th {
            background-color: #6c7ae0;
            color: white;
            text-align: center;
            font-weight: 600;
            padding: 10px 15px;
            border-bottom: 2px solid #ddd;
        }

        table.dataTable td {
            padding: 10px 15px;
            text-align: center;
            vertical-align: middle;
        }

        .add-btn {
            margin-bottom: 15px;
            text-align: right;
        }

        /* Row hover effect */
        table.dataTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling pagination buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 16px;
            margin-left: 3px;
            margin-right: 3px;
            color: #6c7ae0 !important;
            background-color: #f4f4f9;
            border-radius: 4px;
            border: 1px solid #6c7ae0;
            transition: all 0.3s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #6c7ae0;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #6c7ae0;
            color: white !important;
        }

        /* Custom scrollbar for pagination */
        ::-webkit-scrollbar {
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #6c7ae0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f4f4f9;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table.dataTable {
                font-size: 12px;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 6px 10px;
            }
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>USER LIST WITH DATATABLES</h2>
        <div class="add-btn text-right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
        </div>
        <table id="guestTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <input type="hidden" id="userId"> <!-- Hidden field for user ID -->
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name">
                            <div class="error" id="first_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name">
                            <div class="error" id="last_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="user_phone">
                            <div class="error" id="user_phone_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="user_email">
                            <div class="error" id="user_email_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="error" id="gender_error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="first_name">
                            <div class="error" id="editFirstNameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="last_name">
                            <div class="error" id="editLastNameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editPhone" name="phone">
                            <div class="error" id="editPhoneError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                            <div class="error" id="editEmailError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editGender" class="form-label">Gender</label>
                            <select id="editGender" class="form-control" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="error" id="editGenderError"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS (if you're using Bootstrap modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const constraints = {
            first_name: {
                presence: {
                    allowEmpty: false
                },
                format: {
                    pattern: /^[a-zA-Z]+$/,
                    message: "must contain only alphabetic characters"
                }
            },
            last_name: {
                presence: {
                    allowEmpty: false
                },
                format: {
                    pattern: /^[a-zA-Z]+$/,
                    message: "must contain only alphabetic characters"
                }
            },
            user_email: {
                presence: {
                    allowEmpty: false
                },
                format: {
                    pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                    message: "is not a valid email address"
                }
            },
            user_phone: {
                presence: {
                    allowEmpty: false
                },
                format: {
                    pattern: /^\d{10}$/,
                    message: "must be a valid 10-digit number"
                }
            },
            gender: {
                presence: {
                    allowEmpty: false
                }
            }
        };

        function openEditModal(id, first_name, last_name, user_phone, user_email, gender) {
            console.log('Edit Modal Data:', {
                id,
                first_name,
                last_name,
                user_phone,
                user_email,
                gender
            });

            document.getElementById('editUserId').value = id || '';
            document.getElementById('editFirstName').value = first_name || '';
            document.getElementById('editLastName').value = last_name || '';
            document.getElementById('editPhone').value = user_phone || '';
            document.getElementById('editEmail').value = user_email || '';
            document.getElementById('editGender').value = gender || '';

            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }

        function closeEditModal() {
            new bootstrap.Modal(document.getElementById('editUserModal')).hide();
        }

        document.getElementById('editUserForm').addEventListener('submit',
            function updateUser(event) {
                event.preventDefault();

                var id = $('#editUserId').val();
                var first_name = $('#editFirstName').val();
                var last_name = $('#editLastName').val();
                var user_phone = $('#editPhone').val();
                var user_email = $('#editEmail').val();
                var gender = $('#editGender').val();

                // Perform AJAX call to update the user
                $.ajax({
                    url: "update.php",
                    type: "POST",
                    data: {
                        id: id,
                        first_name: first_name,
                        last_name: last_name,
                        user_phone: user_phone,
                        user_email: user_email,
                        gender: gender
                    },
                    success: function(response) {
                        if (response.trim() === "success") {
                            $('#editUserModal').modal('hide');
                            $('#guestTable').DataTable().ajax.reload();
                        } else {
                            alert("Error occurred when updating user: " + response);
                        }
                    }
                });
            }
        );



        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#guestTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "data.php",
                "columns": [{
                        "data": 1
                    }, // Name
                    {
                        "data": 2
                    }, // Phone
                    {
                        "data": 3
                    }, // Email
                    {
                        "data": 4
                    }, // Gender
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            // Ensure the data being passed matches the expected format
                            return `
                              <button class='btn btn-success btn-sm' 
                            onclick="openEditModal(${row[0]}, '${row[1].split(' ')[0]}', '${row[1].split(' ')[1]}', '${row[2]}', '${row[3]}', '${row[4]}')">
                            Edit
                        </button>
                            <button class='btn btn-danger btn-sm delete-btn' data-id='${row[0]}'>Delete</button>`;
                        }

                    }
                ]
            });


            // Handle Add User Form submission
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();

                // Get form values
                var id = $('#userId').val(); // ID is set when editing
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var user_phone = $('#user_phone').val();
                var user_email = $('#user_email').val();
                var gender = $('#gender').val();

                // Validate form
                var formData = {
                    first_name: first_name,
                    last_name: last_name,
                    user_email: user_email,
                    user_phone: user_phone,
                    gender: gender
                };

                var errors = validate(formData, constraints);
                $('.error').text(''); // Clear previous error messages

                if (errors) {
                    for (var field in errors) {
                        $('#' + field + '_error').text(errors[field]);
                    }
                } else {
                    // var url = id ? "edit_user.php" : "add_user.php";
                    $.ajax({
                        url: "add_user.php",
                        type: "POST",
                        data: {
                            id: id, // Pass ID if editing
                            first_name: first_name,
                            last_name: last_name,
                            user_phone: user_phone,
                            user_email: user_email,
                            gender: gender
                        },
                        success: function(data) {
                            $('#addUserModal').modal('hide');
                            table.ajax.reload();
                        }
                    });
                }
            });



            $('#addUserModal').on('show.bs.modal', function() {
                $('#userId').val(''); // Clear hidden ID field
                $('#addUserForm')[0].reset(); // Clear form inputs
                $('.error').text(''); // Clear previous error messages
                $('#addUserModalLabel').text('Add User');
            });







            // Handle Delete button click
            $('#guestTable').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                console.log(id);

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: "delete_user.php",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            console.log(data);
                            table.ajax.reload();
                        }
                    });
                }
            });

            // Reset form and show modal for adding new user
            $('#addUserModal').on('show.bs.modal', function() {
                $('#userId').val(''); // Clear hidden ID field
                $('#addUserForm')[0].reset();
                $('.error').text(''); // Clear previous error messages
                $('#addUserModalLabel').text('Add User');
            });
        });
    </script>

</body>

</html>