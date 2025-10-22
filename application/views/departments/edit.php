<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Department</h1>
                <a href="<?php echo base_url('departments'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Departments
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Edit Department
                    </h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('departments/edit/' . $department->id); ?>
                        <div class="mb-3">
                            <label class="form-label">Department Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $department->name); ?>" required>
                            <?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?php echo set_value('description', $department->description); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" <?php echo $department->is_active ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo !$department->is_active ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('departments'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Department
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>