<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-2">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="font-weight-bold text-uppercase nav-item nav-link active" href="{{route('institute.index')}}">Institutes</a>
                <a class="font-weight-bold text-uppercase nav-item nav-link" href="{{route('teacher.index')}}">Teachers</a>
                <a class="font-weight-bold text-uppercase nav-item nav-link" href="{{route('book.index')}}">Books</a>
            </div>
        </div>
    </nav>
    <div class="row mt-2">
        <div class="col-md-12 card-header text-center font-weight-bold">
            <h3>Teachers List</h3>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewTeacher" class="btn btn-success">Add Teacher</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book</th>
                    <th scope="col">Institute</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($teachers as $index=>$teacher)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $teacher->book->title }}</td>
                        <td>{{ $teacher->institute->name }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>{{ $teacher->designation }}</td>
                        <td>
                            @if($teacher->status == 'Active')
                                <span class="badge badge-success">{{ $teacher->status }}</span>
                            @else
                                <span class="badge badge-danger">{{ $teacher->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $teacher->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $teacher->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $teachers->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-book-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxTeacherModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditTeacherForm" name="addEditTeacherForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Book</label>
                        <div class="col-sm-12">
                            <select name="book_id" id="book_id" class="form-control">
                                <option value="" selected disabled>Select Book</option>
                                @foreach($books as $book)
                                <option value="{{$book->id}}">{{$book->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Institute</label>
                        <div class="col-sm-12">
                            <select name="institute_id" id="institute_id" class="form-control">
                                <option value="" selected disabled>Select Institute</option>
                                @foreach($institutes as $institute)
                                <option value="{{$institute->id}}">{{$institute->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Teacher Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Teacher Name" value="" maxlength="30" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="" maxlength="11" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Designation</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation" value="" maxlength="30" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-12">
                            <select name="status" id="status" class="form-control">
                                <option value="" selected disabled>Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->
<script type="text/javascript">
    $(document).ready(function($){

        //Meta name declaration
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //add new teacher button
        $('#addNewTeacher').click(function () {
            $('#addEditTeacherForm').trigger("reset");
            $('#ajaxTeacherModel').html("Add Teacher");
            $('#ajax-book-model').modal('show');
        });

        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-teacher') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#ajaxBookModel').html("Edit Teacher");
                    $('#ajax-book-model').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#phone').val(res.phone);
                    $('#designation').val(res.designation);
                    $('#institute_id').val(res.institute_id);
                    $('#book_id').val(res.book_id);
                    $('#status').val(res.status);
                }
            });
        });

        $('body').on('click', '.delete', function () {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-teacher') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                    }
                });
            }
        });

        $('body').on('click', '#btn-save', function (event) {
            var id = $("#id").val();
            var name = $("#name").val();
            var phone = $("#phone").val();
            var designation = $("#designation").val();
            var institute_id = $("#institute_id").val();
            var book_id = $("#book_id").val();
            var status = $("#status").val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save"). attr("disabled", true);

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('add-update-teacher') }}",
                data: {
                    id:id,
                    name:name,
                    phone:phone,
                    designation:designation,
                    institute_id:institute_id,
                    book_id:book_id,
                    status:status,
                },
                dataType: 'json',
                success: function(res){
                    window.location.reload();
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                }
            });
        });
    });
</script>
</body>
</html>
