<?php
/**
 * HRMS Installation Script
 * This script helps you set up the HRMS system
 */

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    die('PHP 7.4 or higher is required. Current version: ' . PHP_VERSION);
}

// Check required extensions
$required_extensions = ['mysqli', 'gd', 'mbstring', 'json'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (!empty($missing_extensions)) {
    die('Missing required PHP extensions: ' . implode(', ', $missing_extensions));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .install-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="install-card">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3><i class="fas fa-users"></i> HRMS Installation</h3>
                        <p class="mb-0">Human Resource Management System Setup</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Step 1: System Check -->
                        <div class="step active" id="step1">
                            <h5 class="mb-3"><i class="fas fa-check-circle text-success"></i> System Requirements Check</h5>
                            
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>PHP Version</td>
                                            <td>
                                                <?php if (version_compare(PHP_VERSION, '7.4.0', '>=')): ?>
                                                    <span class="badge bg-success"><?php echo PHP_VERSION; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?php echo PHP_VERSION; ?> (Required: 7.4+)</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php foreach ($required_extensions as $ext): ?>
                                        <tr>
                                            <td><?php echo strtoupper($ext); ?> Extension</td>
                                            <td>
                                                <?php if (extension_loaded($ext)): ?>
                                                    <span class="badge bg-success">Installed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Missing</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Directory Permissions</td>
                                            <td>
                                                <?php 
                                                $writable_dirs = ['assets/uploads', 'assets/uploads/employees', 'application/cache', 'application/logs'];
                                                $all_writable = true;
                                                foreach ($writable_dirs as $dir) {
                                                    if (!is_writable($dir) && !is_dir($dir)) {
                                                        $all_writable = false;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <?php if ($all_writable): ?>
                                                    <span class="badge bg-success">OK</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Check Permissions</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Next Steps:</strong>
                                <ol class="mb-0 mt-2">
                                    <li>Create a MySQL database named 'hrms_db'</li>
                                    <li>Import the database schema from 'database/hrms_schema.sql'</li>
                                    <li>Update database configuration in 'application/config/database.php'</li>
                                    <li>Update base URL in 'application/config/config.php'</li>
                                </ol>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-secondary" onclick="checkSystem()">
                                    <i class="fas fa-sync"></i> Recheck System
                                </button>
                                <button class="btn btn-primary" onclick="nextStep()">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Database Configuration -->
                        <div class="step" id="step2">
                            <h5 class="mb-3"><i class="fas fa-database text-primary"></i> Database Configuration</h5>
                            
                            <form id="dbForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Database Host</label>
                                            <input type="text" class="form-control" name="hostname" value="localhost" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Database Port</label>
                                            <input type="text" class="form-control" name="port" value="3306" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Database Name</label>
                                            <input type="text" class="form-control" name="database" value="hrms_db" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Database Driver</label>
                                            <select class="form-select" name="dbdriver" required>
                                                <option value="mysqli" selected>MySQLi</option>
                                                <option value="pdo">PDO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="root" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Important:</strong> Make sure the database 'hrms_db' exists and the user has proper permissions.
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="testConnection()">
                                        <i class="fas fa-plug"></i> Test Connection
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Step 3: Application Configuration -->
                        <div class="step" id="step3">
                            <h5 class="mb-3"><i class="fas fa-cog text-primary"></i> Application Configuration</h5>
                            
                            <form id="appForm">
                                <div class="mb-3">
                                    <label class="form-label">Base URL</label>
                                    <input type="url" class="form-control" name="base_url" 
                                           value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']); ?>" required>
                                    <div class="form-text">Example: http://localhost/hrms/</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Encryption Key</label>
                                    <input type="text" class="form-control" name="encryption_key" 
                                           value="<?php echo bin2hex(random_bytes(32)); ?>" required>
                                    <div class="form-text">A random 32-character string for encryption</div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Default Admin Account:</strong><br>
                                    Username: admin<br>
                                    Password: admin123
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="installSystem()">
                                        <i class="fas fa-rocket"></i> Install HRMS
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Step 4: Installation Complete -->
                        <div class="step" id="step4">
                            <div class="text-center">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                <h4 class="mt-3">Installation Complete!</h4>
                                <p class="text-muted">Your HRMS system has been successfully installed.</p>
                                
                                <div class="alert alert-success">
                                    <strong>Next Steps:</strong>
                                    <ol class="mb-0 mt-2 text-start">
                                        <li>Delete this install.php file for security</li>
                                        <li>Access your HRMS system using the login credentials</li>
                                        <li>Update the default admin password</li>
                                        <li>Configure your company settings</li>
                                    </ol>
                                </div>
                                
                                <a href="auth/login" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Go to Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 4;
        
        function showStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
        }
        
        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
        
        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }
        
        function checkSystem() {
            location.reload();
        }
        
        function testConnection() {
            const formData = new FormData(document.getElementById('dbForm'));
            // This would typically make an AJAX call to test the database connection
            alert('Database connection test would be implemented here.');
        }
        
        function installSystem() {
            const formData = new FormData(document.getElementById('appForm'));
            // This would typically make an AJAX call to save the configuration
            alert('System installation would be implemented here.');
            nextStep();
        }
    </script>
</body>
</html>