<div class="welcome-section">
    <h2 class="welcome-title">
        <i class="fa fa-chart-line me-2"></i>
        Welcome to Admin Dashboard
    </h2>
    <p class="welcome-subtitle">Manage your restaurant operations efficiently</p>
</div>

<div class="stats-container">
    <div class="stat-card users">
        <div class="stat-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="stat-title">Total Users</div>
        <div class="stat-value"><?=$total_users?></div>
    </div>
    
    <div class="stat-card products">
        <div class="stat-icon">
            <i class="fa fa-hamburger"></i>
        </div>
        <div class="stat-title">Total Products</div>
        <div class="stat-value"><?=$total_products?></div>
    </div>
    
    <div class="stat-card sales">
        <div class="stat-icon">
            <i class="fa fa-money-bill-wave"></i>
        </div>
        <div class="stat-title">Total Sales</div>
        <div class="stat-value">K<?=$total_sales?></div>
    </div>
</div>