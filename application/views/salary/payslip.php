<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Salary Payslip</h1>
                <div>
                    <a href="<?php echo base_url('salary?month=' . $month . '&year=' . $year); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Salary List
                    </a>
                    <button class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Payslip
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0">Salary Payslip - <?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Employee Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold">Name:</td>
                                    <td><?php echo $employee->full_name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Employee Code:</td>
                                    <td><?php echo $employee->employee_code; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Department:</td>
                                    <td><?php echo $employee->department_name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Designation:</td>
                                    <td><?php echo $employee->designation_name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Salary Type:</td>
                                    <td><?php echo ucfirst($employee->salary_type); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-end">
                            <img src="<?php echo base_url('assets/uploads/employees/' . ($employee->profile_photo ?: 'default.jpg')); ?>" 
                                 class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Attendance Summary</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold">Present Days:</td>
                                    <td><?php echo $salary['present_days']; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Absent Days:</td>
                                    <td><?php echo $salary['absent_days']; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Late Days:</td>
                                    <td><?php echo $salary['late_days']; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Approved Leaves:</td>
                                    <td><?php echo $salary['approved_leaves']; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Working Days:</td>
                                    <td><?php echo $salary['total_days']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Salary Breakdown</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold">Basic Salary:</td>
                                    <td class="text-success">$<?php echo number_format($salary['basic'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Deductions:</td>
                                    <td class="text-danger">$<?php echo number_format($salary['deductions'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Net Salary:</td>
                                    <td class="fw-bold">$<?php echo number_format($salary['net_salary'], 2); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h5 class="fw-bold">Net Salary: $<?php echo number_format($salary['net_salary'], 2); ?></h5>
                            <p class="text-muted">This is a system-generated payslip and does not require a signature.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@media print {
    .btn, .navbar, .sidebar, .card-header, .card-footer, .d-flex, .mb-4, .alert, .form-label, .form-control, .form-select, .datatable, .dataTables_wrapper { display: none !important; }
    .card { box-shadow: none !important; border: none !important; }
    body { background: #fff !important; }
}
</style>