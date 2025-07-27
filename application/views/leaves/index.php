<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Leave Management</h1>
                <div>
                    <a href="<?php echo base_url('leaves/add'); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Leave Request
                    </a>
                    <a href="<?php echo base_url('leaves/calendar'); ?>" class="btn btn-info">
                        <i class="fas fa-calendar-alt"></i> Calendar View
                    </a>
                    <a href="<?php echo base_url('leaves/report'); ?>" class="btn btn-warning">
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Leave Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_leaves; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending_leaves; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $approved_leaves; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rejected_leaves; ?></div>
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
            <form method="GET" action="<?php echo base_url('leaves'); ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="pending" <?php echo $this->input->get('status') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo $this->input->get('status') == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="rejected" <?php echo $this->input->get('status') == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Leave Type</label>
                        <select class="form-select" name="leave_type_id">
                            <option value="">All Types</option>
                            <?php foreach ($leave_types as $type): ?>
                                <option value="<?php echo $type->id; ?>" <?php echo $this->input->get('leave_type_id') == $type->id ? 'selected' : ''; ?>>
                                    <?php echo $type->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
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
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="date_from" value="<?php echo $this->input->get('date_from'); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="date_to" value="<?php echo $this->input->get('date_to'); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="<?php echo base_url('leaves'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Leave Requests Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list"></i> Leave Requests
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($leaves)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Date Range</th>
                                <th>Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaves as $leave): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo base_url('assets/uploads/employees/' . ($leave->profile_photo ?: 'default.jpg')); ?>" 
                                                 class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold"><?php echo $leave->full_name; ?></div>
                                                <small class="text-muted"><?php echo $leave->employee_code; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo $leave->leave_type_name; ?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>From:</strong> <?php echo date('M j, Y', strtotime($leave->start_date)); ?><br>
                                            <strong>To:</strong> <?php echo date('M j, Y', strtotime($leave->end_date)); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo $leave->total_days; ?> days</span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?php echo $leave->reason; ?>">
                                            <?php echo $leave->reason; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($leave->status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif ($leave->status == 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($leave->status == 'rejected'): ?>
                                            <span class="badge bg-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo date('M j, Y', strtotime($leave->created_at)); ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo base_url('leaves/view/' . $leave->id); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <?php if ($leave->status == 'pending'): ?>
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        onclick="approveLeave(<?php echo $leave->id; ?>)" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="rejectLeave(<?php echo $leave->id; ?>)" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <a href="<?php echo base_url('leaves/edit/' . $leave->id); ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete('<?php echo base_url('leaves/delete/' . $leave->id); ?>')" title="Delete">
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
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No leave requests found</h5>
                    <p class="text-muted">No leave requests match the selected filters.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Approve Leave Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" name="remarks" rows="3" placeholder="Add any remarks..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Leave Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="remarks" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveLeave(leaveId) {
    document.getElementById('approveForm').action = '<?php echo base_url('leaves/approve/'); ?>' + leaveId;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectLeave(leaveId) {
    document.getElementById('rejectForm').action = '<?php echo base_url('leaves/reject/'); ?>' + leaveId;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this leave request? This action cannot be undone.')) {
        window.location.href = url;
    }
}
</script>