@extends('app')

@section('content')

    <!-- Add Student Model -->
    <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="saveForm_errorList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" class="name form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" class="email form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" class="phone form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Course</label>
                        <input type="text" class="course form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_student">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Student Model -->

    <!-- Edit Student Model -->
    <div class="modal fade" id="EditStudentModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="updateForm_errorList"></ul>
                    <input type="hidden" id="edit_stud_id">

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" id="edit_phone" class="phone form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Course</label>
                        <input type="text" id="edit_course" class="course form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Student Model -->

    <!-- Delete Student Model -->
    <div class="modal fade" id="DeleteStudentModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_stud_id">
                    <h4>Are you sure> want to delete this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary confirm_delete_student">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Student Model -->

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div id="success_message">

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Student Data<a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary float-end btn-sm">Add Student</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                   <th>ID</th>
                                   <th>Name</th>
                                   <th>Email</th>
                                   <th>Phone</th>
                                   <th>Course</th>
                                   <th>Edit</th>
                                   <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            function fetchStudent(){
                $.ajax({
                    type: "GET",
                    url: "/fetch-students",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.students, function (key, item) {
                            $('tbody').append(
                                '<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td>'+item.course+'</td>\
                                    <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                    <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                                </tr>'
                            );
                        });
                    }
                });
            }

            $(document).on('click', '.add_student', function (e){
                e.preventDefault();
                var data = {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                    'phone': $('.phone').val(),
                    'course': $('.course').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 400){
                            $('#saveForm_errorList').html("");
                            $('#saveForm_errorList').addClass("alert alert-danger");
                            $.each(response.errors, function (key, err_values) {
                                $('#saveForm_errorList').append('<li>'+err_values+'</li>');
                            });
                        } else {
                            $('#saveForm_errorList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStudentModal').modal('hide');
                            $('#AddStudentModal').find('input').val("");
                            fetchStudent();
                        }
                    }
                });
            });

            $(document).on('click', '.edit_student', function (e){
               e.preventDefault();
                const student_id = $(this).val();
                $('#EditStudentModel').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-student/"+student_id,
                    success: function (response){
                        if(response.status === 404){
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#edit_name').val(response.student.name);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            $('#edit_course').val(response.student.course);
                            $('#edit_stud_id').val(student_id);
                        }
                    }
                });
            });

            $(document).on('click', '.update_student', function (e){
               e.preventDefault();
               $(this).text("Updating")
               const student_id = $('#edit_stud_id').val();
               var data = {
                   'name': $('#edit_name').val(),
                   'email': $('#edit_email').val(),
                   'phone': $('#edit_phone').val(),
                   'course': $('#edit_course').val()
               };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

               $.ajax({
                   type: "PUT",
                   url: "/update-student/"+student_id,
                   data: data,
                   dataType:"json",
                   success: function (response){
                       if (response.status === 400){
                           $('#updateForm_errorList').html("");
                           $('#updateForm_errorList').addClass("alert alert-danger");
                           $.each(response.errors, function (key, err_values) {
                               $('#updateForm_errorList').append('<li>'+err_values+'</li>');
                           });
                           $('.update_student').text("Update")
                       } else if (response.status === 404) {
                           $('#updateForm_errorList').html("");
                           $('#success_message').addClass('alert alert-success');
                           $('#success_message').text(response.message);
                           $('.update_student').text("Update")
                           fetchStudent();
                       } else {
                           $('#updateForm_errorList').html("");
                           $('#success_message').html("");
                           $('#success_message').addClass('alert alert-success');
                           $('#success_message').text(response.message);
                           $('#EditStudentModel').modal('hide');
                           $('.update_student').text("Update")
                           fetchStudent();
                       }
                   }
               });
            });

            $(document).on('click', '.delete_student', function (e){
               e.preventDefault();
               const student_id = $(this).val();
               $('#delete_stud_id').val(student_id);
               $('#DeleteStudentModel').modal('show');
            });

            $(document).on('click', '.confirm_delete_student', function (e){
                e.preventDefault();
                const student_id = $('#delete_stud_id').val();

                $(this).text("Deleting");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-student/"+student_id,
                    success: function (response){
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#DeleteStudentModel').modal("hide");
                        $('.confirm_delete_student').text("Yes Delete");
                        fetchStudent();
                    }
                });
            });

            fetchStudent();
        });
    </script>
@endsection
