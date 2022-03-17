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

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Teachers List</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewTeacher" class="btn btn-success">Add Teacher</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Author</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($teachers as $index=>$teacher)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>{{ $teacher->designation }}</td>
                        <td>{{ $teacher->author }}</td>
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
                        <label class="col-sm-4 control-label">Author</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="author" name="author" placeholder="Enter author Name" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                        </button>
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
                    $('#author').val(res.author);
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
            var author = $("#author").val();

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
                    author:author,
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
