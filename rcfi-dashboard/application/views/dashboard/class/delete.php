<script>
function getDelete(id,url){

swal({
  title: "Are you sure?",
  text: "You will not be able to recover this Account!",
  icon: "warning",
  buttons: [
	'No, cancel it!',
	'Yes, I am sure!'
  ],
  dangerMode: true,
}).then(function(isConfirm) {
  if (isConfirm) {

	$.ajax({
		type: 'ajax',
		method: 'post',
		url: url,
		data: {id: id},
		async: false,
		dataType: 'text',
		success: function(data){
			
		},
		error: function(){
			swal('Could not edit data');
		}
	});

	swal({
	  title: 'Deleted Successfully!',
	  text: 'Candidates are successfully shortlisted!',
	  icon: 'success'
	}).then(function() {
		//RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
		location.reload();
	});
  } else {
	swal("Cancelled", "", "error");
  }
})
};
</script>