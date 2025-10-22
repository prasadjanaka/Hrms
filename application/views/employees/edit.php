<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Employee</h1>
                <a href="<?php echo base_url('employees'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Employees
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit"></i> Edit Employee Information
                    </h5>
                </div>
                <div class="card-body">
                    <?php echo form_open_multipart('employees/edit/' . $employee->id); ?>
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3 text-primary">
                                    <i class="fas fa-user"></i> Personal Information
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="full_name" 
                                                   value="<?php echo set_value('full_name', $employee->full_name); ?>" required>
                                            <?php echo form_error('full_name', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Employee Code</label>
                                            <input type="text" class="form-control" value="<?php echo $employee->employee_code; ?>" readonly>
                                            <small class="form-text text-muted">Employee code cannot be changed</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">NIC <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nic" 
                                                   value="<?php echo set_value('nic', $employee->nic); ?>" required>
                                            <?php echo form_error('nic', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                                            <select class="form-select" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male" <?php echo set_select('gender', 'male', $employee->gender == 'male'); ?>>Male</option>
                                                <option value="female" <?php echo set_select('gender', 'female', $employee->gender == 'female'); ?>>Female</option>
                                                <option value="other" <?php echo set_select('gender', 'other', $employee->gender == 'other'); ?>>Other</option>
                                            </select>
                                            <?php echo form_error('gender', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date_of_birth" 
                                                   value="<?php echo set_value('date_of_birth', $employee->date_of_birth); ?>" required>
                                            <?php echo form_error('date_of_birth', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Joining Date</label>
                                            <input type="date" class="form-control" value="<?php echo $employee->joining_date; ?>" readonly>
                                            <small class="form-text text-muted">Joining date cannot be changed</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" 
                                                   value="<?php echo set_value('phone', $employee->phone); ?>">
                                            <?php echo form_error('phone', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" 
                                                   value="<?php echo set_value('email', $employee->email); ?>" required>
                                            <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?php echo set_value('address', $employee->address); ?></textarea>
                                    <?php echo form_error('address', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            
                            <!-- Work Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3 text-primary">
                                    <i class="fas fa-briefcase"></i> Work Information
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                            <select class="form-select" name="department_id" required>
                                                <option value="">Select Department</option>
                                                <?php foreach ($departments as $dept): ?>
                                                    <option value="<?php echo $dept->id; ?>" 
                                                            <?php echo set_select('department_id', $dept->id, $employee->department_id == $dept->id); ?>>
                                                        <?php echo $dept->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('department_id', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                                            <select class="form-select" name="designation_id" required>
                                                <option value="">Select Designation</option>
                                                <?php foreach ($designations as $desig): ?>
                                                    <option value="<?php echo $desig->id; ?>" 
                                                            <?php echo set_select('designation_id', $desig->id, $employee->designation_id == $desig->id); ?>>
                                                        <?php echo $desig->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('designation_id', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cadre <span class="text-danger">*</span></label>
                                            <select class="form-select" name="cadre_id" required>
                                                <option value="">Select Cadre</option>
                                                <?php foreach ($cadres as $cadre): ?>
                                                    <option value="<?php echo $cadre->id; ?>" 
                                                            <?php echo set_select('cadre_id', $cadre->id, $employee->cadre_id == $cadre->id); ?>>
                                                        <?php echo $cadre->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('cadre_id', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                                            <select class="form-select" name="shift_id" required>
                                                <option value="">Select Shift</option>
                                                <?php foreach ($shifts as $shift): ?>
                                                    <option value="<?php echo $shift->id; ?>" 
                                                            <?php echo set_select('shift_id', $shift->id, $employee->shift_id == $shift->id); ?>>
                                                        <?php echo $shift->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('shift_id', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3 text-primary">
                                    <i class="fas fa-money-bill-wave"></i> Salary Information
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Salary Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="salary_type" id="salary_type" required>
                                                <option value="">Select Salary Type</option>
                                                <option value="monthly" <?php echo set_select('salary_type', 'monthly', $employee->salary_type == 'monthly'); ?>>Monthly Basic</option>
                                                <option value="daily" <?php echo set_select('salary_type', 'daily', $employee->salary_type == 'daily'); ?>>Daily Rate</option>
                                            </select>
                                            <?php echo form_error('salary_type', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <?php if ($employee->profile_photo): ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo base_url('assets/uploads/employees/' . $employee->profile_photo); ?>" 
                                                         alt="Current Photo" class="rounded" width="60" height="60">
                                                    <small class="form-text text-muted">Current photo</small>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" class="form-control" name="profile_photo" accept="image/*">
                                            <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3" id="monthly_rate_div" style="display: none;">
                                            <label class="form-label">Monthly Basic Rate</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" name="monthly_basic_rate" 
                                                       value="<?php echo set_value('monthly_basic_rate', $employee->monthly_basic_rate); ?>" step="0.01" min="0">
                                            </div>
                                            <?php echo form_error('monthly_basic_rate', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3" id="daily_rate_div" style="display: none;">
                                            <label class="form-label">Daily Basic Rate</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" name="daily_basic_rate" 
                                                       value="<?php echo set_value('daily_basic_rate', $employee->daily_basic_rate); ?>" step="0.01" min="0">
                                            </div>
                                            <?php echo form_error('daily_basic_rate', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('employees'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Employee
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('salary_type').addEventListener('change', function() {
    const monthlyDiv = document.getElementById('monthly_rate_div');
    const dailyDiv = document.getElementById('daily_rate_div');
    
    if (this.value === 'monthly') {
        monthlyDiv.style.display = 'block';
        dailyDiv.style.display = 'none';
    } else if (this.value === 'daily') {
        monthlyDiv.style.display = 'none';
        dailyDiv.style.display = 'block';
    } else {
        monthlyDiv.style.display = 'none';
        dailyDiv.style.display = 'none';
    }
});

// Trigger change event on page load to show/hide appropriate fields
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('salary_type').dispatchEvent(new Event('change'));
});
</script>