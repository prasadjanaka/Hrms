<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Add Leave Request</h1>
                <a href="<?php echo base_url('leaves'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Leaves
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus"></i> New Leave Request
                    </h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('leaves/add'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employee <span class="text-danger">*</span></label>
                                    <select class="form-select" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        <?php foreach ($employees as $employee): ?>
                                            <option value="<?php echo $employee->id; ?>" <?php echo set_select('employee_id', $employee->id); ?>>
                                                <?php echo $employee->employee_code . ' - ' . $employee->full_name . ' (' . $employee->department_name . ')'; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('employee_id', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Leave Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="leave_type_id" required>
                                        <option value="">Select Leave Type</option>
                                        <?php foreach ($leave_types as $type): ?>
                                            <option value="<?php echo $type->id; ?>" <?php echo set_select('leave_type_id', $type->id); ?>>
                                                <?php echo $type->name; ?> (<?php echo $type->default_days; ?> days)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('leave_type_id', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" 
                                           value="<?php echo set_value('start_date'); ?>" required>
                                    <?php echo form_error('start_date', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="end_date" 
                                           value="<?php echo set_value('end_date'); ?>" required>
                                    <?php echo form_error('end_date', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" rows="4" 
                                              placeholder="Please provide a detailed reason for the leave request..." required><?php echo set_value('reason'); ?></textarea>
                                    <?php echo form_error('reason', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Calculated Working Days</label>
                                    <input type="text" class="form-control" id="calculated_days" readonly>
                                    <small class="form-text text-muted">This will be calculated automatically based on the date range (excluding weekends)</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('leaves'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Submit Leave Request
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');
    const calculatedDaysInput = document.getElementById('calculated_days');
    
    function calculateWorkingDays() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            
            if (start > end) {
                calculatedDaysInput.value = 'Invalid date range';
                return;
            }
            
            let workingDays = 0;
            const current = new Date(start);
            
            while (current <= end) {
                const dayOfWeek = current.getDay();
                if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Not Sunday (0) or Saturday (6)
                    workingDays++;
                }
                current.setDate(current.getDate() + 1);
            }
            
            calculatedDaysInput.value = workingDays + ' days';
        } else {
            calculatedDaysInput.value = '';
        }
    }
    
    startDateInput.addEventListener('change', calculateWorkingDays);
    endDateInput.addEventListener('change', calculateWorkingDays);
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;
    endDateInput.min = today;
    
    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
    });
});
</script>