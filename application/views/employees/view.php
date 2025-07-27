<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Employee Profile</h1>
                <div>
                    <a href="<?php echo base_url('employees/edit/' . $employee->id); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo base_url('employees'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Employees
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Employee Photo and Basic Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if ($employee->profile_photo): ?>
                        <img src="<?php echo base_url('assets/uploads/employees/' . $employee->profile_photo); ?>" 
                             alt="Profile Photo" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="mb-1"><?php echo $employee->full_name; ?></h4>
                    <p class="text-muted mb-2"><?php echo $employee->employee_code; ?></p>
                    <span class="badge bg-<?php echo $employee->is_active ? 'success' : 'danger'; ?>">
                        <?php echo $employee->is_active ? 'Active' : 'Inactive'; ?>
                    </span>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary"><?php echo $attendance_stats['present_this_month'] ?? 0; ?></h5>
                            <small class="text-muted">Present Days</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning"><?php echo $attendance_stats['late_this_month'] ?? 0; ?></h5>
                            <small class="text-muted">Late Days</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-success"><?php echo $leave_stats['approved_leaves'] ?? 0; ?></h5>
                            <small class="text-muted">Approved Leaves</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-info"><?php echo $leave_stats['pending_leaves'] ?? 0; ?></h5>
                            <small class="text-muted">Pending Leaves</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Employee Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="employeeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                                <i class="fas fa-user"></i> Personal Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work" type="button" role="tab">
                                <i class="fas fa-briefcase"></i> Work Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                                <i class="fas fa-clock"></i> Attendance
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="leaves-tab" data-bs-toggle="tab" data-bs-target="#leaves" type="button" role="tab">
                                <i class="fas fa-calendar-alt"></i> Leaves
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="employeeTabsContent">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="40%">Full Name:</td>
                                            <td><?php echo $employee->full_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Employee Code:</td>
                                            <td><?php echo $employee->employee_code; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">NIC:</td>
                                            <td><?php echo $employee->nic; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Gender:</td>
                                            <td>
                                                <span class="badge bg-<?php echo $employee->gender == 'male' ? 'primary' : ($employee->gender == 'female' ? 'pink' : 'secondary'); ?>">
                                                    <?php echo ucfirst($employee->gender); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Date of Birth:</td>
                                            <td><?php echo date('F j, Y', strtotime($employee->date_of_birth)); ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="40%">Email:</td>
                                            <td>
                                                <a href="mailto:<?php echo $employee->email; ?>"><?php echo $employee->email; ?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Phone:</td>
                                            <td>
                                                <?php if ($employee->phone): ?>
                                                    <a href="tel:<?php echo $employee->phone; ?>"><?php echo $employee->phone; ?></a>
                                                <?php else: ?>
                                                    <span class="text-muted">Not provided</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Address:</td>
                                            <td><?php echo $employee->address ?: 'Not provided'; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Joining Date:</td>
                                            <td><?php echo date('F j, Y', strtotime($employee->joining_date)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                <span class="badge bg-<?php echo $employee->is_active ? 'success' : 'danger'; ?>">
                                                    <?php echo $employee->is_active ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Work Information Tab -->
                        <div class="tab-pane fade" id="work" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="40%">Department:</td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $employee->department_name; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Designation:</td>
                                            <td><?php echo $employee->designation_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Cadre:</td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $employee->cadre_name; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Shift:</td>
                                            <td>
                                                <span class="badge bg-warning"><?php echo $employee->shift_name; ?></span>
                                                <small class="text-muted d-block">
                                                    <?php echo $employee->shift_start_time . ' - ' . $employee->shift_end_time; ?>
                                                </small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="40%">Salary Type:</td>
                                            <td>
                                                <span class="badge bg-<?php echo $employee->salary_type == 'monthly' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst($employee->salary_type); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">
                                                <?php echo $employee->salary_type == 'monthly' ? 'Monthly Rate:' : 'Daily Rate:'; ?>
                                            </td>
                                            <td>
                                                <strong class="text-success">
                                                    $<?php echo number_format($employee->salary_type == 'monthly' ? $employee->monthly_basic_rate : $employee->daily_basic_rate, 2); ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Working Days:</td>
                                            <td><?php echo $employee->shift_working_days; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attendance Tab -->
                        <div class="tab-pane fade" id="attendance" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6>This Month's Attendance</h6>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-success mb-0"><?php echo $attendance_stats['present_this_month'] ?? 0; ?></h5>
                                                <small class="text-muted">Present</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-warning mb-0"><?php echo $attendance_stats['late_this_month'] ?? 0; ?></h5>
                                                <small class="text-muted">Late</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-danger mb-0"><?php echo $attendance_stats['absent_this_month'] ?? 0; ?></h5>
                                                <small class="text-muted">Absent</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Today's Status</h6>
                                    <?php if (isset($today_attendance)): ?>
                                        <div class="alert alert-info">
                                            <strong>Check-in:</strong> <?php echo $today_attendance->check_in_time; ?><br>
                                            <?php if ($today_attendance->check_out_time): ?>
                                                <strong>Check-out:</strong> <?php echo $today_attendance->check_out_time; ?><br>
                                                <strong>Worked Hours:</strong> <?php echo $today_attendance->worked_hours; ?> hours
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-clock"></i> Not checked in today
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <h6>Recent Attendance</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recent_attendance)): ?>
                                            <?php foreach ($recent_attendance as $att): ?>
                                                <tr>
                                                    <td><?php echo date('M j, Y', strtotime($att->date)); ?></td>
                                                    <td><?php echo $att->check_in_time; ?></td>
                                                    <td><?php echo $att->check_out_time ?: '-'; ?></td>
                                                    <td><?php echo $att->worked_hours ?: '-'; ?></td>
                                                    <td>
                                                        <?php if ($att->is_late): ?>
                                                            <span class="badge bg-warning">Late</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">On Time</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No recent attendance records</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Leaves Tab -->
                        <div class="tab-pane fade" id="leaves" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6>Leave Balance</h6>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-success mb-0"><?php echo $leave_stats['sick_balance'] ?? 0; ?></h5>
                                                <small class="text-muted">Sick Leave</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-info mb-0"><?php echo $leave_stats['casual_balance'] ?? 0; ?></h5>
                                                <small class="text-muted">Casual Leave</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-warning mb-0"><?php echo $leave_stats['annual_balance'] ?? 0; ?></h5>
                                                <small class="text-muted">Annual Leave</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Leave Summary</h6>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-success mb-0"><?php echo $leave_stats['approved_leaves'] ?? 0; ?></h5>
                                                <small class="text-muted">Approved</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-warning mb-0"><?php echo $leave_stats['pending_leaves'] ?? 0; ?></h5>
                                                <small class="text-muted">Pending</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h5 class="text-danger mb-0"><?php echo $leave_stats['rejected_leaves'] ?? 0; ?></h5>
                                                <small class="text-muted">Rejected</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <h6>Recent Leave Requests</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Days</th>
                                            <th>Status</th>
                                            <th>Applied On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recent_leaves)): ?>
                                            <?php foreach ($recent_leaves as $leave): ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-<?php echo $leave->leave_type == 'sick' ? 'danger' : ($leave->leave_type == 'casual' ? 'info' : 'warning'); ?>">
                                                            <?php echo ucfirst($leave->leave_type); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo date('M j, Y', strtotime($leave->start_date)); ?></td>
                                                    <td><?php echo date('M j, Y', strtotime($leave->end_date)); ?></td>
                                                    <td><?php echo $leave->days; ?></td>
                                                    <td>
                                                        <?php if ($leave->status == 'approved'): ?>
                                                            <span class="badge bg-success">Approved</span>
                                                        <?php elseif ($leave->status == 'rejected'): ?>
                                                            <span class="badge bg-danger">Rejected</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">Pending</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo date('M j, Y', strtotime($leave->created_at)); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No recent leave requests</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>