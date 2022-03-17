<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 8 Ajax CRUD Tutorial</title>
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
            <h3>Book List</h3>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add Book</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Book Code</th>
                    <th scope="col">Book Author</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->code }}</td>
                        <td>{{ $book->author }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $book->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $book->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $books->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-book-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Book Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Book Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Book Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Book Code" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Book Author</label>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addNewBook').click(function () {
            $('#addEditBookForm').trigger("reset");
            $('#ajaxBookModel').html("Add Book");
            $('#ajax-book-model').modal('show');
        });

        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-book') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#ajaxBookModel').html("Edit Book");
                    $('#ajax-book-model').modal('show');
                    $('#id').val(res.id);
                    $('#title').val(res.title);
                    $('#code').val(res.code);
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
                    url: "{{ url('delete-book') }}",
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
            var title = $("#title").val();
            var code = $("#code").val();
            var author = $("#author").val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save"). attr("disabled", true);

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('add-update-book') }}",
                data: {
                    id:id,
                    title:title,
                    code:code,
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
