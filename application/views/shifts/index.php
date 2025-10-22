<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Shifts</h1>
                <a href="<?php echo base_url('shifts/add'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Shift
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-clock"></i> Shift List
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($shifts)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Working Days</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shifts as $shift): ?>
                                <tr>
                                    <td><?php echo $shift->name; ?></td>
                                    <td><?php echo $shift->start_time; ?></td>
                                    <td><?php echo $shift->end_time; ?></td>
                                    <td>
                                        <?php 
                                        $days = explode(',', $shift->working_days);
                                        $day_names = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                                        foreach ($days as $d) {
                                            echo '<span class="badge bg-info me-1">' . $day_names[$d] . '</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($shift->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('shifts/edit/' . $shift->id); ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?php echo base_url('shifts/delete/' . $shift->id); ?>')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No shifts found</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this shift? This action cannot be undone.')) {
        window.location.href = url;
    }
}
</script>