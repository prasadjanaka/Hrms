<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Employee Management</h1>
                <a href="<?php echo base_url('employees/add'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Employee
                </a>
            </div>
        </div>
    </div>
    
    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo base_url('employees'); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="keyword" 
                                   value="<?php echo $filters['keyword']; ?>" 
                                   placeholder="Name, Code, Email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id">
                                <option value="">All Departments</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept->id; ?>" 
                                            <?php echo $filters['department_id'] == $dept->id ? 'selected' : ''; ?>>
                                        <?php echo $dept->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Shift</label>
                            <select class="form-select" name="shift_id">
                                <option value="">All Shifts</option>
                                <?php foreach ($shifts as $shift): ?>
                                    <option value="<?php echo $shift->id; ?>" 
                                            <?php echo $filters['shift_id'] == $shift->id ? 'selected' : ''; ?>>
                                        <?php echo $shift->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Cadre</label>
                            <select class="form-select" name="cadre_id">
                                <option value="">All Cadres</option>
                                <?php foreach ($cadres as $cadre): ?>
                                    <option value="<?php echo $cadre->id; ?>" 
                                            <?php echo $filters['cadre_id'] == $cadre->id ? 'selected' : ''; ?>>
                                        <?php echo $cadre->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="<?php echo base_url('employees'); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Employees List -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users"></i> Employees (<?php echo count($employees); ?>)
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($employees)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Employee Code</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Cadre</th>
                                <th>Shift</th>
                                <th>Salary Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <td>
                                        <?php if ($employee->profile_photo): ?>
                                            <img src="<?php echo base_url('assets/uploads/employees/' . $employee->profile_photo); ?>" 
                                                 alt="Profile" class="rounded-circle" width="40" height="40">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo $employee->employee_code; ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo $employee->full_name; ?></strong>
                                            <br><small class="text-muted"><?php echo $employee->email; ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $employee->department_name ?: '-'; ?>
                                    </td>
                                    <td>
                                        <?php echo $employee->designation_name ?: '-'; ?>
                                    </td>
                                    <td>
                                        <?php echo $employee->cadre_name ?: '-'; ?>
                                    </td>
                                    <td>
                                        <?php echo $employee->shift_name ?: '-'; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo ucfirst($employee->salary_type); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($employee->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo base_url('employees/view/' . $employee->id); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo base_url('employees/edit/' . $employee->id); ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete('<?php echo base_url('employees/delete/' . $employee->id); ?>')" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No employees found</h5>
                    <p class="text-muted">Try adjusting your search criteria or add a new employee.</p>
                    <a href="<?php echo base_url('employees/add'); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Employee
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
        window.location.href = url;
    }
}
</script>