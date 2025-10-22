<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Shift</h1>
                <a href="<?php echo base_url('shifts'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Shifts
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Edit Shift
                    </h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('shifts/edit/' . $shift->id); ?>
                        <div class="mb-3">
                            <label class="form-label">Shift Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $shift->name); ?>" required>
                            <?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="start_time" value="<?php echo set_value('start_time', $shift->start_time); ?>" required>
                                <?php echo form_error('start_time', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="end_time" value="<?php echo set_value('end_time', $shift->end_time); ?>" required>
                                <?php echo form_error('end_time', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Working Days <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']; ?>
                                <?php foreach ($days as $i => $day): ?>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="working_days[]" value="<?php echo $i; ?>" id="day_<?php echo $i; ?>" <?php echo in_array((string)$i, $shift->working_days) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="day_<?php echo $i; ?>"><?php echo $day; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php echo form_error('working_days', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1" <?php echo $shift->is_active ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo !$shift->is_active ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('shifts'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Shift
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>