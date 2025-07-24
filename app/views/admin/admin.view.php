<?php require views_path('partials/header');?>

<style>
.admin-container {
    min-height: calc(100vh - 80px);
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
}

.admin-header {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 20px;
    text-align: center;
    border-left: 5px solid #e74c3c;
}

.admin-title {
    color: #2c3e50;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.admin-title i {
    color: #e74c3c;
    font-size: 32px;
}

.admin-content {
    display: flex;
    gap: 20px;
    min-height: calc(100vh - 200px);
}

.sidebar {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 25px;
    width: 280px;
    flex-shrink: 0;
}

.sidebar-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
    text-align: center;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 10px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    color: #6c757d;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 500;
    border: 2px solid transparent;
}

.nav-link:hover {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.1);
    transform: translateX(5px);
    text-decoration: none;
}

.nav-link.active {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.15);
    border-color: #e74c3c;
    font-weight: 600;
}

.nav-link i {
    font-size: 18px;
    width: 20px;
    text-align: center;
}

.main-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 30px;
    flex: 1;
    overflow-y: auto;
}

.content-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.content-title {
    color: #2c3e50;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.content-title::before {
    content: '';
    width: 4px;
    height: 25px;
    background: #e74c3c;
    border-radius: 2px;
}

.logout-link {
    color: #dc3545;
    border: 2px solid #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.logout-link:hover {
    color: white;
    background: #dc3545;
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .admin-content {
        flex-direction: column;
    }
    
    .sidebar {
        width: 100%;
        order: 2;
    }
    
    .main-content {
        order: 1;
    }
    
    .nav-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .nav-item {
        margin-bottom: 0;
        flex: 1;
        min-width: 150px;
    }
}
</style>

<div class="admin-container">
    <div class="admin-header">
        <h2 class="admin-title">
            <i class="fa fa-user-shield"></i>
            Admin Dashboard
        </h2>
    </div>

    <div class="admin-content">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="sidebar-title">
                <i class="fa fa-bars"></i>
                Navigation
            </h4>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=dashboard" class="nav-link <?=!$tab || $tab == 'dashboard'?'active':''?>">
                        <i class="fa fa-th-large"></i>
                        Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=users" class="nav-link <?=$tab=='users'?'active':''?>">
                        <i class="fa fa-users"></i>
                        Users
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=products" class="nav-link <?=$tab=='products'?'active':''?>">
                        <i class="fa fa-hamburger"></i>
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=sales" class="nav-link <?=$tab=='sales'?'active':''?>">
                        <i class="fa fa-money-bill-wave"></i>
                        Sales
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=graph" class="nav-link <?=$tab=='graph'?'active':''?>">
                        <i class="fa fa-chart-bar"></i>
                        Graph
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?pg=admin&tab=register" class="nav-link <?=$tab=='register'?'active':''?>">
                        <i class="fa fa-book"></i>
                        Register
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?pg=logout" class="nav-link logout-link">
                        <i class="fa fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h3 class="content-title">
                    <?=strtoupper($tab)?>
                </h3>
            </div>

            <?php  
                switch ($tab) {
                    case 'products':
                        require views_path('admin/products');
                        break;

                    case 'users':
                        require views_path('admin/users');
                        break;

                    case 'sales':
                        require views_path('admin/sales');
                        break;
                    
                    case 'graph':
                        require views_path('admin/graph');
                        break;
                    
                    case 'register':
                        require views_path('admin/register');
                        break;
                    
                    default:
                        require views_path('admin/dashboard');
                        break;
                }
            ?>
        </div>
    </div>
</div>

<?php require views_path('partials/footer');?>