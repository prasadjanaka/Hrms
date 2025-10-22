<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Leave Calendar</h1>
                <div>
                    <a href="<?php echo base_url('leaves'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Leaves
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Calendar Navigation -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">
                        <?php echo date('F Y', mktime(0, 0, 0, $month, 1, $year)); ?>
                    </h4>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group" role="group">
                        <a href="<?php echo base_url('leaves/calendar?month=' . ($month - 1) . '&year=' . ($month == 1 ? $year - 1 : $year)); ?>" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                        <a href="<?php echo base_url('leaves/calendar?month=' . date('m') . '&year=' . date('Y')); ?>" 
                           class="btn btn-outline-secondary">
                            Today
                        </a>
                        <a href="<?php echo base_url('leaves/calendar?month=' . ($month + 1) . '&year=' . ($month == 12 ? $year + 1 : $year)); ?>" 
                           class="btn btn-outline-primary">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Calendar -->
    <div class="card">
        <div class="card-body">
            <div class="calendar">
                <!-- Calendar Header -->
                <div class="calendar-header">
                    <div class="calendar-day-header">Sun</div>
                    <div class="calendar-day-header">Mon</div>
                    <div class="calendar-day-header">Tue</div>
                    <div class="calendar-day-header">Wed</div>
                    <div class="calendar-day-header">Thu</div>
                    <div class="calendar-day-header">Fri</div>
                    <div class="calendar-day-header">Sat</div>
                </div>
                
                <!-- Calendar Body -->
                <div class="calendar-body">
                    <?php
                    $first_day = mktime(0, 0, 0, $month, 1, $year);
                    $days_in_month = date('t', $first_day);
                    $day_of_week = date('w', $first_day);
                    
                    // Create array of leaves for easy lookup
                    $leaves_by_date = array();
                    foreach ($leaves as $leave) {
                        $start = strtotime($leave->start_date);
                        $end = strtotime($leave->end_date);
                        
                        for ($d = $start; $d <= $end; $d += 86400) {
                            $date_key = date('Y-m-d', $d);
                            if (!isset($leaves_by_date[$date_key])) {
                                $leaves_by_date[$date_key] = array();
                            }
                            $leaves_by_date[$date_key][] = $leave;
                        }
                    }
                    
                    // Print empty cells for days before the first day of the month
                    for ($i = 0; $i < $day_of_week; $i++) {
                        echo '<div class="calendar-day empty"></div>';
                    }
                    
                    // Print days of the month
                    for ($day = 1; $day <= $days_in_month; $day++) {
                        $current_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
                        $is_today = $current_date == date('Y-m-d');
                        $has_leaves = isset($leaves_by_date[$current_date]);
                        
                        $day_class = 'calendar-day';
                        if ($is_today) $day_class .= ' today';
                        if ($has_leaves) $day_class .= ' has-leaves';
                        
                        echo '<div class="' . $day_class . '">';
                        echo '<div class="day-number">' . $day . '</div>';
                        
                        if ($has_leaves) {
                            echo '<div class="leave-indicators">';
                            foreach ($leaves_by_date[$current_date] as $leave) {
                                $color = $leave->color ?: '#007bff';
                                echo '<div class="leave-indicator" style="background-color: ' . $color . '" title="' . $leave->full_name . ' - ' . $leave->leave_type_name . '"></div>';
                            }
                            echo '</div>';
                        }
                        
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Leave Legend -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Leave Legend</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                $leave_types = array();
                foreach ($leaves as $leave) {
                    $type_key = $leave->leave_type_name;
                    if (!isset($leave_types[$type_key])) {
                        $leave_types[$type_key] = $leave->color ?: '#007bff';
                    }
                }
                
                foreach ($leave_types as $type_name => $color):
                ?>
                <div class="col-md-3 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="leave-legend-indicator me-2" style="background-color: <?php echo $color; ?>"></div>
                        <span><?php echo $type_name; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
.calendar {
    font-family: Arial, sans-serif;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.calendar-day-header {
    padding: 10px;
    text-align: center;
    font-weight: bold;
    background-color: #e9ecef;
    border-bottom: 1px solid #dee2e6;
}

.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.calendar-day {
    min-height: 100px;
    padding: 8px;
    background-color: white;
    border: 1px solid #dee2e6;
    position: relative;
}

.calendar-day.empty {
    background-color: #f8f9fa;
}

.calendar-day.today {
    background-color: #fff3cd;
    border-color: #ffc107;
}

.calendar-day.has-leaves {
    background-color: #f8f9fa;
}

.day-number {
    font-weight: bold;
    margin-bottom: 5px;
}

.leave-indicators {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
}

.leave-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.leave-legend-indicator {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: inline-block;
}

@media (max-width: 768px) {
    .calendar-day {
        min-height: 60px;
        padding: 4px;
    }
    
    .day-number {
        font-size: 12px;
    }
    
    .leave-indicator {
        width: 6px;
        height: 6px;
    }
}
</style>