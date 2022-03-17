<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Institute List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Institutes List</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewInstitute" class="btn btn-success">Add Institute</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Institute Code</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($institutes as $index=>$institute)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $institute->name }}</td>
                        <td>{{ $institute->institute_code }}</td>
                        <td>{{ $institute->status }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $institute->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $institute->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $institutes->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-institute-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxInstituteModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditInstituteForm" name="addEditInstituteForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Institute Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Institute Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Institute Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="institute_code" name="institute_code" placeholder="Enter Institute Code Number" value="" maxlength="11" required="">
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
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewInstitute">Save changes</button>
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
    $(document).ready(function ($){
        //Meta name declaration
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Add new Institute
        $('#addNewInstitute').click(function (){
            $('#addEditInstituteForm').trigger("reset");
            $('#ajaxInstituteModel').html("Add Institute");
            $('#ajax-institute-model').modal('show');
        });

        //Data store
        $('body').on('click','#btn-save', function (event){
            var id = $('#id').val();
            var name = $('#name').val();
            var institute_code = $('#institute_code').val();
            var status = $('#status').val();

            $('#btn-save').html('Please wait....');
            $('#btn-save').attr('disabled', true);

            //Ajax
            $.ajax({
                type: "POST",
                url: "{{url('add-update-institute')}}",
                data:{
                    id:id,
                    name:name,
                    institute_code:institute_code,
                    status:status
                },
                dataType: 'json',
                success: function (res){
                    window.location.reload();
                    $('#btn-save').html('Submit');
                    $('#btn-save').attr('disabled',true);
                }
            });
        });


        //Data Edit
        $('body').on('click', '.edit', function (){
            var id = $(this).data('id');

            //Ajax
            $.ajax({
                type:'POST',
                url: '{{url('edit-institute')}}',
                data: {id:id},
                dataType: 'json',
                success: function (res){
                    $('#ajaxInstituteModel').html("Edit Institute");
                    $('#ajax-institute-model').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#institute_code').val(res.institute_code);
                    $('#status').val(res.status);
                }
            });
        });

        //data delete
        $('body').on('click', '.delete', function () {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-institute') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
</body>
</html>
