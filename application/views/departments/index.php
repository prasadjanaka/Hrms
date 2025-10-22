<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Departments</h1>
                <a href="<?php echo base_url('departments/add'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Department
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-building"></i> Department List
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($departments)): ?>
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $dept): ?>
                                <tr>
                                    <td><?php echo $dept->name; ?></td>
                                    <td><?php echo $dept->description; ?></td>
                                    <td>
                                        <?php if ($dept->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('departments/edit/' . $dept->id); ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?php echo base_url('departments/delete/' . $dept->id); ?>')">
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
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No departments found</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this department? This action cannot be undone.')) {
        window.location.href = url;
    }
}
</script>