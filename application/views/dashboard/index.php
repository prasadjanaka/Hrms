<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Dashboard</h1>
                <div class="text-muted">
                    <i class="fas fa-calendar"></i> <?php echo date('l, F j, Y'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo $total_employees; ?></h4>
                        <p class="mb-0">Total Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo $total_departments; ?></h4>
                        <p class="mb-0">Departments</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo $present_today; ?></h4>
                        <p class="mb-0">Present Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo $on_leave_today; ?></h4>
                        <p class="mb-0">On Leave Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line"></i> Attendance Trend (Last 7 Days)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie"></i> Employees by Department
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="departmentChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock"></i> Recent Attendance
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_attendances)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_attendances as $attendance): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $attendance->full_name; ?></strong>
                                                <br><small class="text-muted"><?php echo $attendance->employee_code; ?></small>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($attendance->date)); ?></td>
                                            <td>
                                                <?php if ($attendance->status == 'present'): ?>
                                                    <span class="badge bg-success">Present</span>
                                                <?php elseif ($attendance->status == 'late'): ?>
                                                    <span class="badge bg-warning">Late</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?php echo ucfirst($attendance->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($attendance->in_time): ?>
                                                    <?php echo date('H:i', strtotime($attendance->in_time)); ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">No recent attendance records</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt"></i> Recent Leave Requests
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_leaves)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_leaves as $leave): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $leave->full_name; ?></strong>
                                                <br><small class="text-muted"><?php echo $leave->employee_code; ?></small>
                                            </td>
                                            <td><?php echo $leave->leave_type_name; ?></td>
                                            <td>
                                                <?php if ($leave->status == 'approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php elseif ($leave->status == 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo date('M j', strtotime($leave->start_date)); ?> - 
                                                <?php echo date('M j', strtotime($leave->end_date)); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">No recent leave requests</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Attendance Trend Chart
const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($attendance_trend, 'date')); ?>,
        datasets: [{
            label: 'Present',
            data: <?php echo json_encode(array_column($attendance_trend, 'present')); ?>,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Absent',
            data: <?php echo json_encode(array_column($attendance_trend, 'absent')); ?>,
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Department Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
const departmentChart = new Chart(departmentCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_column($department_stats, 'department_name')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($department_stats, 'employee_count')); ?>,
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#f093fb',
                '#f5576c',
                '#4facfe',
                '#00f2fe'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>