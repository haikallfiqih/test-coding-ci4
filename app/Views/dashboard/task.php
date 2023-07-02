<?= $this->extend('layout/dashboard-layout') ?>

<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>


<?= $this->section('breadcrumb') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $pageTitle ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= route_to('dashboard.home') ?>">Home</a></li>
                    <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">List of Task</div>
            <div class="card-body">
                <table class="table table-hover" id="task-table">
                    <thead>
                        <th>#</th>
                        <th>Task Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Add New Task</div>
            <div class="card-body">
                <form action="<?= route_to('task.store'); ?>" method="post" id="add-new-task" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Task name</label>
                        <input type="text" class="form-control" name="task_name" placeholder="Enter new task">
                        <span class="text-danger error-text task_name_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('components/edit-task-modal') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('datatables/js/jquery.dataTables.js'); ?>" ></script>
<script src="<?= base_url('datatables/js/dataTables.bootstrap4.min.js'); ?>" ></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

let csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
let csrfHash = $('meta.csrf').attr('content'); //CSRF HASH


 $('#add-new-task').submit(function(e){
        e.preventDefault();
        let form = this;
        $.ajax({
           url:$(form).attr('action'),
           method:$(form).attr('method'),
           data:new FormData(form),
           processData:false,
           dataType:'json',
           contentType:false,
           beforeSend:function(){
              $(form).find('span.error-text').text('');
           },
           success: function(data) {
                if (data.success) {
                    $(form)[0].reset();
                    swal(data.success);
                    $('#task-table').DataTable().ajax.reload(null, false);
                } else if (data.error) {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }

        });
   });


   $('#task-table').DataTable({
       "processing":true,
       "serverSide":true,
       "ajax": "<?= route_to('get.all.task'); ?>",
       "dom":"lBfrtip",
       stateSave:true,
       "iDisplayLength":5,
       "pageLength":5,
       "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
       "fnCreatedRow": function(row, data, index){
           $('td',row).eq(0).html(index+1);
       }
   });

   $(document).on('click','#updateTaskBtn', function(){
       let task_id = $(this).data('id');
 
        $.post("<?= route_to('get.task.info') ?>", {task_id: task_id, [csrfName]: csrfHash}, function(data) {
            $('.editTask').find('form').find('input[name="tid"]').val(data.results.id);
            $('.editTask').find('form').find('input[name="task_name"]').val(data.results.task_name);
            $('.editTask').find('form').find('input[name="task_status"]').prop('checked', data.results.task_status == 1);
            $('.editTask').find('form').find('span.error-text').text('');
            $('.editTask').modal('show');
        }, 'json');

   });

   $('#update-task-form').submit(function(e) {
    e.preventDefault();
    let form = this;

    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: new FormData(form),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function() {
            $(form).find('span.error-text').text('');
        },
        success: function(data) {
            if ($.isEmptyObject(data.error)) {
                if (data.code == 1) {
                    $('#task-table').DataTable().ajax.reload(null, false);
                    $('.editTask').modal('hide');
                    swal('Task info has been updated successfully');
                } else {
                    swal('Something went wrong while updating the task');
                }
            } else {
                $.each(data.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        },
        error: function() {
            // Error occurred during the AJAX request
            swal('An error occurred while updating the task');
        }
        });
    });

    $(document).on('click', '#deleteTaskBtn', function(){
    let task_id = $(this).data('id');
    let url = "<?= route_to('task.delete'); ?>";

    swal({
        title: 'Are you sure?',
        text: 'You want to delete this task',
        icon: 'warning',
        buttons: ['Cancel', 'Yes, delete'],
        dangerMode: true,
        closeOnClickOutside: false,
    }).then(function(result){
        if(result){
            $.post(url, {[csrfName]: csrfHash, task_id: task_id}, function(data) {
                if (data.code == 1) {
                    $('#task-table').DataTable().ajax.reload(null, false);
                    swal('Task has been deleted successfully.');
                } else {
                    swal('Error: ' + data.msg);
                }
            }, 'json').fail(function() {
                swal('Something went wrong while deleting the task.');
            });
        }
        });
    });

</script>
<?= $this->endSection() ?>
