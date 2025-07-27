<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Manual Attendance Marking</h1>
                <a href="<?php echo base_url('attendance'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Attendance
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Mark Employee Attendance
                    </h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('attendance/manual_mark'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employee <span class="text-danger">*</span></label>
                                    <select class="form-select" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        <?php foreach ($employees as $employee): ?>
                                            <option value="<?php echo $employee->id; ?>" <?php echo set_select('employee_id', $employee->id); ?>>
                                                <?php echo $employee->employee_code . ' - ' . $employee->full_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('employee_id', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" 
                                           value="<?php echo set_value('date', date('Y-m-d')); ?>" required>
                                    <?php echo form_error('date', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Check-in Time</label>
                                    <input type="time" class="form-control" name="in_time" 
                                           value="<?php echo set_value('in_time'); ?>">
                                    <small class="form-text text-muted">Leave empty if employee was absent</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Check-out Time</label>
                                    <input type="time" class="form-control" name="out_time" 
                                           value="<?php echo set_value('out_time'); ?>">
                                    <small class="form-text text-muted">Leave empty if employee was absent</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="present" <?php echo set_select('status', 'present'); ?>>Present</option>
                                        <option value="late" <?php echo set_select('status', 'late'); ?>>Late</option>
                                        <option value="absent" <?php echo set_select('status', 'absent'); ?>>Absent</option>
                                        <option value="half_day" <?php echo set_select('status', 'half_day'); ?>>Half Day</option>
                                    </select>
                                    <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('attendance'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mark Attendance
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Marking Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt"></i> Quick Marking
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" id="quick_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="quick_status">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-success" onclick="markAllPresent()">
                                        <i class="fas fa-check"></i> Mark All Present
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="markAllAbsent()">
                                        <i class="fas fa-times"></i> Mark All Absent
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Quick Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo base_url('assets/uploads/employees/' . ($employee->profile_photo ?: 'default.jpg')); ?>" 
                                                     class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold"><?php echo $employee->full_name; ?></div>
                                                    <small class="text-muted"><?php echo $employee->employee_code; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $employee->department_name; ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-success" 
                                                        onclick="quickMark(<?php echo $employee->id; ?>, 'present')">
                                                    Present
                                                </button>
                                                <button type="button" class="btn btn-outline-warning" 
                                                        onclick="quickMark(<?php echo $employee->id; ?>, 'late')">
                                                    Late
                                                </button>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="quickMark(<?php echo $employee->id; ?>, 'absent')">
                                                    Absent
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function quickMark(employeeId, status) {
    const date = document.getElementById('quick_date').value;
    
    if (!date) {
        alert('Please select a date');
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('employee_id', employeeId);
    formData.append('date', date);
    formData.append('status', status);
    
    // Send AJAX request
    fetch('<?php echo base_url('attendance/manual_mark'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Show success message
        alert('Attendance marked successfully');
        // Optionally refresh the page or update the UI
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error marking attendance');
    });
}

function markAllPresent() {
    const date = document.getElementById('quick_date').value;
    const status = document.getElementById('quick_status').value;
    
    if (!date) {
        alert('Please select a date');
        return;
    }
    
    if (confirm('Are you sure you want to mark all employees as ' + status + '?')) {
        // Get all employee IDs
        const employeeIds = <?php echo json_encode(array_column($employees, 'id')); ?>;
        
        // Mark each employee
        employeeIds.forEach(employeeId => {
            quickMark(employeeId, status);
        });
    }
}

function markAllAbsent() {
    markAllPresent(); // Reuse the function with 'absent' status
}
</script>