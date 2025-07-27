<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Attendance Management</h1>
                <div>
                    <a href="<?php echo base_url('attendance/manual_mark'); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Manual Mark
                    </a>
                    <a href="<?php echo base_url('attendance/report'); ?>" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Employees</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_employees; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Present Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $present_today; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Late Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $late_today; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Absent Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $absent_today; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo base_url('attendance'); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <select class="form-select" name="department_id">
                            <option value="">All Departments</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept->id; ?>" <?php echo $this->input->get('department_id') == $dept->id ? 'selected' : ''; ?>>
                                    <?php echo $dept->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="present" <?php echo $this->input->get('status') == 'present' ? 'selected' : ''; ?>>Present</option>
                            <option value="late" <?php echo $this->input->get('status') == 'late' ? 'selected' : ''; ?>>Late</option>
                            <option value="absent" <?php echo $this->input->get('status') == 'absent' ? 'selected' : ''; ?>>Absent</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="<?php echo base_url('attendance'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Attendance Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-calendar-check"></i> Daily Attendance - <?php echo date('F j, Y', strtotime($date)); ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($attendances)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Shift</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Worked Hours</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendances as $attendance): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo base_url('assets/uploads/employees/' . ($attendance->profile_photo ?: 'default.jpg')); ?>" 
                                                 class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold"><?php echo $attendance->full_name; ?></div>
                                                <small class="text-muted"><?php echo $attendance->employee_code; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $attendance->department_name; ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo $attendance->shift_name ?? 'N/A'; ?></span>
                                    </td>
                                    <td>
                                        <?php if ($attendance->in_time): ?>
                                            <span class="text-success"><?php echo $attendance->in_time; ?></span>
                                            <?php if ($attendance->is_late): ?>
                                                <i class="fas fa-exclamation-triangle text-warning ms-1" title="Late"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Not checked in</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($attendance->out_time): ?>
                                            <span class="text-info"><?php echo $attendance->out_time; ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Not checked out</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($attendance->worked_hours): ?>
                                            <span class="fw-bold"><?php echo $attendance->worked_hours; ?> hrs</span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($attendance->status == 'present'): ?>
                                            <span class="badge bg-success">Present</span>
                                        <?php elseif ($attendance->status == 'late'): ?>
                                            <span class="badge bg-warning">Late</span>
                                        <?php elseif ($attendance->status == 'absent'): ?>
                                            <span class="badge bg-danger">Absent</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if (!$attendance->in_time): ?>
                                                <form method="POST" action="<?php echo base_url('attendance/check_in'); ?>" style="display: inline;">
                                                    <input type="hidden" name="employee_id" value="<?php echo $attendance->employee_id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Check In">
                                                        <i class="fas fa-sign-in-alt"></i>
                                                    </button>
                                                </form>
                                            <?php elseif (!$attendance->out_time): ?>
                                                <form method="POST" action="<?php echo base_url('attendance/check_out'); ?>" style="display: inline;">
                                                    <input type="hidden" name="employee_id" value="<?php echo $attendance->employee_id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-info" title="Check Out">
                                                        <i class="fas fa-sign-out-alt"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <a href="<?php echo base_url('attendance/employee/' . $attendance->employee_id); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No attendance records found</h5>
                    <p class="text-muted">No employees have attendance records for the selected date.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>