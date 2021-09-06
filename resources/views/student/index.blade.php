@extends('layouts.app');

@section('content')

<!-- Modal -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      	<ul id="saveform_errlist"></ul>
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


<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit & Update Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      	<ul id="updateform_errlist"></ul>
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




<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      	<input type="hidden" id="delete_stud_id">
        <h4>Are you sure you want to delete?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_student">Yes</button>
      </div>
    </div>
  </div>
</div>


<div class="container py-5">
	<div class="row">
		<div class="col-md-12">
			<div id="saveform_success"></div>
			<div class="card">
				<div class="card-header">
					<h4>Students Data
						<a href="#" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#AddStudentModal">Add Student</a>
					</h4>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-stripped">
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
	$(document).ready(function() {

		fetchstudent();

		function fetchstudent()
		{
			$.ajax({
				type: 'GET',
				url: '/fetch-student',
				dataType: "json",
				success : function(result){
					//console.log(result.students);
				$('tbody').html("");
					$.each(result.students,function(key, item) {

						$('tbody').append('<tr>\
								<td>'+item.id+'</td>\
								<td>'+item.name+'</td>\
								<td>'+item.email+'</td>\
								<td>'+item.phone+'</td>\
								<td>'+item.course+'</td>\
								<td><button type="button" class="edit_button btn btn-primary btn-sm" value="'+item.id+'">Edit</button></td>\
								<td><button type="button" class="delete_button btn btn-primary btn-sm btn-danger" value="'+item.id+'">Delete</button></td>\
							</tr>');
						
					});
				}
			});
		}

		$(document).on('click', '.edit_button', function(e) {
			e.preventDefault();
			var stud_id = $(this).val();
//console.log(stud_id);
			$('#EditStudentModal').modal('show');

			$.ajax({
				type: 'GET',
				url: '/edit-student/'+stud_id,
				success : function(result){
					//console.log(result);

					if(result.status == 404)
					{
						$('#saveform_errlist').html("");
						$('#saveform_success').addClass("alert alert-danger");
						$('#saveform_success').text(result.message);
					}
					else
					{
						$('#edit_name').val(result.students.name);
						$('#edit_email').val(result.students.email);
						$('#edit_phone').val(result.students.phone);
						$('#edit_course').val(result.students.course);
						$('#edit_stud_id').val(stud_id);
					}
				}
			});

		});

		$(document).on('click', '.add_student', function(e) {

			e.preventDefault();

			var name = $('.name').val();
			var email = $('.email').val();
			var phone = $('.phone').val();
			var course = $('.course').val();

			var data = {
				'name' : name,
				'email' : email,
				'phone' : phone,
				'course' : course,
			}
			
			//console.log(data);
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$.ajax({
				type: 'POST',
				url: '/students',
				data: data,
				dataType: "json",
				success : function(result){
					//console.log(result);

					if(result.status == 400)
					{
						$('#saveform_errlist').html("");
						$('#saveform_errlist').addClass("alert alert-danger");
						$.each(result.errors,function(key, err_values) {

							$('#saveform_errlist').append('<li>'+err_values+'</li>');
							
						});
					}
					else
					{
						$('#saveform_errlist').html("");
						$('#saveform_success').addClass("alert alert-success");
						$('#saveform_success').text(result.message);
						$('#AddStudentModal').modal('hide');
						$('#AddStudentModal').find('input').val('');
						fetchstudent();
					}
				}
			});
			
		});





		$(document).on('click', '.update_student', function(e) {

			e.preventDefault();

			var stud_id = $('#edit_stud_id').val();
			var name = $('#edit_name').val();
			var email = $('#edit_email').val();
			var phone = $('#edit_phone').val();
			var course = $('#edit_course').val();

			var data = {
				'name' : name,
				'email' : email,
				'phone' : phone,
				'course' : course,
			}
			
			//console.log(data);
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$.ajax({
				type: 'PUT',
				url: '/update-student/'+stud_id,
				data: data,
				dataType: "json",
				success : function(result){
					//console.log(result);

					if(result.status == 400)
					{
						$('#updateform_errlist').html("");
						$('#updateform_errlist').addClass("alert alert-danger");
						$.each(result.errors,function(key, err_values) {

							$('#updateform_errlist').append('<li>'+err_values+'</li>');
							
						});
					}
					else if(result.status == 404)
					{
						$('#updateform_errlist').html("");
						$('#saveform_success').addClass("alert alert-success");
						$('#saveform_success').text(result.message);
					}
					else
					{
						$('#updateform_errlist').html("");
						$('#saveform_success').addClass("alert alert-success");
						$('#saveform_success').text(result.message);
						$('#EditStudentModal').modal('hide');
						$('#EditStudentModal').find('input').val('');
						fetchstudent();
					}
				}
			});
			
		});


		$(document).on('click', '.delete_button', function(e) {
			e.preventDefault();
			var stud_id = $(this).val();
			//console.log(stud_id);
			$('#delete_stud_id').val(stud_id);
			$('#DeleteStudentModal').modal('show');
		});


		$(document).on('click', '.delete_student', function(e) {
			e.preventDefault();
			var stud_id = $('#delete_stud_id').val();
//console.log(stud_id);

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$.ajax({
				type: 'DELETE',
				url: '/delete-student/'+stud_id,
				success : function(result){
					//console.log(result);
					$('#saveform_success').addClass("alert alert-success");
					$('#saveform_success').text(result.message);
					$('#DeleteStudentModal').modal('hide');
					fetchstudent();
				}
			});

		});

		
	});
</script>

@endsection