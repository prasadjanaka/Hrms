<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Leave Request Details</h1>
                <div>
                    <?php if ($leave->status == 'pending'): ?>
                        <button type="button" class="btn btn-success" onclick="approveLeave(<?php echo $leave->id; ?>)">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button type="button" class="btn btn-danger" onclick="rejectLeave(<?php echo $leave->id; ?>)">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    <?php endif; ?>
                    <a href="<?php echo base_url('leaves/edit/' . $leave->id); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo base_url('leaves'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Leaves
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Leave Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt"></i> Leave Request Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Employee:</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo base_url('assets/uploads/employees/' . ($employee->profile_photo ?: 'default.jpg')); ?>" 
                                                 class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold"><?php echo $employee->full_name; ?></div>
                                                <small class="text-muted"><?php echo $employee->employee_code; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Department:</td>
                                    <td><?php echo $employee->department_name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Leave Type:</td>
                                    <td>
                                        <span class="badge bg-info"><?php echo $leave->leave_type_name; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <?php if ($leave->status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif ($leave->status == 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($leave->status == 'rejected'): ?>
                                            <span class="badge bg-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Start Date:</td>
                                    <td><?php echo date('F j, Y', strtotime($leave->start_date)); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">End Date:</td>
                                    <td><?php echo date('F j, Y', strtotime($leave->end_date)); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Days:</td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo $leave->total_days; ?> working days</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Applied On:</td>
                                    <td><?php echo date('F j, Y g:i A', strtotime($leave->created_at)); ?></td>
                                </tr>
                                <?php if ($leave->approved_by_name): ?>
                                <tr>
                                    <td class="fw-bold">Processed By:</td>
                                    <td><?php echo $leave->approved_by_name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processed On:</td>
                                    <td><?php echo date('F j, Y g:i A', strtotime($leave->approved_at)); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6>Reason for Leave</h6>
                            <div class="alert alert-light">
                                <?php echo nl2br($leave->reason); ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($leave->remarks): ?>
                    <div class="row">
                        <div class="col-12">
                            <h6>Remarks</h6>
                            <div class="alert alert-info">
                                <?php echo nl2br($leave->remarks); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Leave Balance -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Leave Balance</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-success mb-0"><?php echo $leave_balance['total']; ?></h4>
                                <small class="text-muted">Total Days</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-warning mb-0"><?php echo $leave_balance['used']; ?></h4>
                                <small class="text-muted">Used Days</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-0"><?php echo $leave_balance['remaining']; ?></h4>
                            <small class="text-muted">Remaining Days</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo base_url('employees/view/' . $employee->id); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-user"></i> View Employee Profile
                        </a>
                        <a href="<?php echo base_url('leaves'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-list"></i> All Leave Requests
                        </a>
                        <?php if ($leave->status == 'pending'): ?>
                        <button type="button" class="btn btn-outline-success" onclick="approveLeave(<?php echo $leave->id; ?>)">
                            <i class="fas fa-check"></i> Approve Request
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="rejectLeave(<?php echo $leave->id; ?>)">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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
                    <p>Are you sure you want to approve this leave request for <strong><?php echo $employee->full_name; ?></strong>?</p>
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
                    <p>Are you sure you want to reject this leave request for <strong><?php echo $employee->full_name; ?></strong>?</p>
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
</script>