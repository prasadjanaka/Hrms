<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Cadres</h1>
                <a href="<?php echo base_url('cadres/add'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Cadre
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-layer-group"></i> Cadre List
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($cadres)): ?>
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
                            <?php foreach ($cadres as $cadre): ?>
                                <tr>
                                    <td><?php echo $cadre->name; ?></td>
                                    <td><?php echo $cadre->description; ?></td>
                                    <td>
                                        <?php if ($cadre->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('cadres/edit/' . $cadre->id); ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('<?php echo base_url('cadres/delete/' . $cadre->id); ?>')">
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
                    <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No cadres found</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this cadre? This action cannot be undone.')) {
        window.location.href = url;
    }
}
</script>