<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Attendance Report</h1>
                <a href="<?php echo base_url('reports/attendance?month=' . $month . '&year=' . $year . '&department_id=' . $this->input->get('department_id')); ?>&export=csv" class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo base_url('reports/attendance'); ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Month</label>
                        <select class="form-select" name="month">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo sprintf('%02d', $m); ?>" <?php echo $month == sprintf('%02d', $m) ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0,0,0,$m,1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Year</label>
                        <select class="form-select" name="year">
                            <?php for ($y = date('Y') - 3; $y <= date('Y') + 1; $y++): ?>
                                <option value="<?php echo $y; ?>" <?php echo $year == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
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
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-calendar-check"></i> Attendance Summary - <?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($attendance_data)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th>Total Days</th>
                                <th>Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendance_data as $row): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo $row['employee']->full_name; ?></div>
                                        <small class="text-muted"><?php echo $row['employee']->employee_code; ?></small>
                                    </td>
                                    <td><?php echo $row['employee']->department_name; ?></td>
                                    <td><?php echo $row['summary']->present_days ?: 0; ?></td>
                                    <td><?php echo $row['summary']->absent_days ?: 0; ?></td>
                                    <td><?php echo $row['summary']->late_days ?: 0; ?></td>
                                    <td><?php echo $row['summary']->total_days ?: 0; ?></td>
                                    <td><?php echo $row['summary']->total_hours ?: 0; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No attendance data found</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>