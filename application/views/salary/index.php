<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Salary Management</h1>
                <div>
                    <a href="<?php echo base_url('salary/generate'); ?>" class="btn btn-primary">
                        <i class="fas fa-cogs"></i> Generate Salaries
                    </a>
                    <a href="<?php echo base_url('salary/export?month=' . $month . '&year=' . $year); ?>" class="btn btn-success">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo base_url('salary'); ?>">
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
    
    <!-- Salary Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-money-bill-wave"></i> Salary List - <?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($salary_data)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Salary Type</th>
                                <th>Basic</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($salary_data as $row): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo $row['employee']->full_name; ?></div>
                                        <small class="text-muted"><?php echo $row['employee']->employee_code; ?></small>
                                    </td>
                                    <td><?php echo $row['employee']->department_name; ?></td>
                                    <td><span class="badge bg-info"><?php echo ucfirst($row['employee']->salary_type); ?></span></td>
                                    <td><span class="text-success fw-bold">$<?php echo number_format($row['salary']['basic'], 2); ?></span></td>
                                    <td><span class="text-danger fw-bold">$<?php echo number_format($row['salary']['deductions'], 2); ?></span></td>
                                    <td><span class="fw-bold">$<?php echo number_format($row['salary']['net_salary'], 2); ?></span></td>
                                    <td><?php echo $row['salary']['present_days']; ?></td>
                                    <td><?php echo $row['salary']['absent_days']; ?></td>
                                    <td><?php echo $row['salary']['late_days']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('salary/payslip/' . $row['employee']->id . '/' . $month . '/' . $year); ?>" 
                                           class="btn btn-sm btn-outline-primary" title="View Payslip">
                                            <i class="fas fa-file-invoice-dollar"></i> Payslip
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-money-check-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No salary data found</h5>
                    <p class="text-muted">No salary records for the selected month and filters.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>