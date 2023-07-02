<div class="modal fade editTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('task.update'); ?>" method="post" id="update-task-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="tid">
                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" class="form-control" name="task_name" id="taskName" placeholder="Enter the task name">
                        <span class="text-danger error-text task_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="taskStatus">Task Status</label>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="task_status" id="taskStatus" value="1">
                            <label class="form-check-label" for="taskStatus">Finished</label>
                        </div>
                        <span class="text-danger error-text task_status_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
