<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>HRMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .btn {
            border-radius: 8px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-card .icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="p-3 text-center">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-users"></i> HRMS
                        </h5>
                        <small class="text-white-50">Human Resource Management</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link <?php echo $this->router->class == 'dashboard' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        
                        <?php if ($this->is_hr()): ?>
                        <a class="nav-link <?php echo $this->router->class == 'employees' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('employees'); ?>">
                            <i class="fas fa-user-tie"></i> Employees
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'departments' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('departments'); ?>">
                            <i class="fas fa-building"></i> Departments
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'designations' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('designations'); ?>">
                            <i class="fas fa-id-badge"></i> Designations
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'cadres' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('cadres'); ?>">
                            <i class="fas fa-layer-group"></i> Cadres
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'shifts' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('shifts'); ?>">
                            <i class="fas fa-clock"></i> Shifts
                        </a>
                        <?php endif; ?>
                        
                        <a class="nav-link <?php echo $this->router->class == 'attendance' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('attendance'); ?>">
                            <i class="fas fa-calendar-check"></i> Attendance
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'leaves' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('leaves'); ?>">
                            <i class="fas fa-calendar-times"></i> Leaves
                        </a>
                        
                        <?php if ($this->is_hr()): ?>
                        <a class="nav-link <?php echo $this->router->class == 'salary' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('salary'); ?>">
                            <i class="fas fa-money-bill-wave"></i> Salary
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'reports' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('reports'); ?>">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                        
                        <a class="nav-link <?php echo $this->router->class == 'settings' ? 'active' : ''; ?>" 
                           href="<?php echo base_url('settings'); ?>">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="main-content">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            
                            <div class="navbar-nav ms-auto">
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                                       data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i> 
                                        <?php echo $user->username; ?> 
                                        <span class="badge bg-primary"><?php echo ucfirst($user->role); ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo base_url('auth/change_password'); ?>">
                                            <i class="fas fa-key"></i> Change Password
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                    
                    <!-- Page Content -->
                    <div class="p-4">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>