<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Generate Salaries</h1>
                <a href="<?php echo base_url('salary'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Salary List
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Generate Monthly Salaries</h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('salary/generate'); ?>
                        <div class="mb-3">
                            <label class="form-label">Month <span class="text-danger">*</span></label>
                            <select class="form-select" name="month" required>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo sprintf('%02d', $m); ?>" <?php echo date('m') == sprintf('%02d', $m) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0,0,0,$m,1)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-select" name="year" required>
                                <?php for ($y = date('Y') - 3; $y <= date('Y') + 1; $y++): ?>
                                    <option value="<?php echo $y; ?>" <?php echo date('Y') == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This will calculate and save salary payments for all active employees for the selected month and year.
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('salary'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cogs"></i> Generate Salaries
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>