<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($user['is_first_login'] == 1) {
    header("Location: change_password_first_time.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ví Điện Tử | E-Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        /* Thanh topbar xanh mướt */
        .navbar { background: linear-gradient(135deg, #1a73e8, #0d47a1) !important; border-radius: 0 0 25px 25px; padding: 15px 0; }
        /* Card số dư trắng tinh khôi */
        .balance-card { 
            background: white; border-radius: 20px; border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.3s;
        }
        /* Nút chức năng đổ bóng nhẹ */
        .action-btn { 
            border-radius: 18px; padding: 25px 10px; font-weight: 600; transition: 0.3s; 
            background: white; border: none; color: #444; text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .action-btn:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(13,110,253,0.15); color: #0d6efd; }
        .action-btn i { font-size: 2rem; display: block; margin-bottom: 10px; }
        /* Badge trạng thái */
        .status-badge { border-radius: 30px; padding: 6px 16px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }
        /* Menu quản lý */
        .manage-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .list-group-item { border: none; padding: 15px 20px; font-size: 0.95rem; color: #555; transition: 0.2s; }
        .list-group-item:hover { background-color: #f8f9fa; color: #0d6efd; padding-left: 30px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand fw-bold fs-4"><i class="bi bi-wallet2 me-2"></i>E-WALLET</span>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1 text-primary"></i> <?php echo $user['full_name']; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2 rounded-4">
                    <li><a class="dropdown-item rounded-3" href="get_user_info.php">Thông tin cá nhân</a></li>
                    <li><a class="dropdown-item rounded-3" href="change_password.php">Đổi mật khẩu</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item rounded-3 text-danger" href="logout.php">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card balance-card p-4 text-center mb-4">
                    <span class="text-muted small fw-bold">SỐ DƯ KHẢ DỤNG</span>
                    <h1 class="fw-bold my-3 text-primary"><?php echo number_format($user['balance'], 0, ',', '.'); ?> <small class="fs-6">VND</small></h1>
                    
                    <div class="mb-2">
                        <span class="status-badge <?php echo $user['status'] == 'verified' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'; ?> fw-bold">
                             <i class="bi bi-shield-check"></i> <?php echo ucfirst($user['status']); ?>
                        </span>
                    </div>

                    <?php if($user['status'] == 'waiting_for_updates'): ?>
                        <div class="alert alert-danger mt-3 mb-0 border-0 rounded-4">
                            <p class="small mb-2 fw-bold">Hồ sơ bị từ chối!</p>
                            <a href="reupload_cccd.php" class="btn btn-danger btn-sm w-100 rounded-pill fw-bold">Cập nhật ngay</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card manage-card p-2 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-muted mb-3 ps-2" style="font-size: 0.8rem;">QUẢN LÝ TÀI KHOẢN</h6>
                        <div class="list-group">
                            <a href="get_user_info.php" class="list-group-item list-group-item-action"><i class="bi bi-person-vcard me-3"></i>Hồ sơ cá nhân</a>
                            <a href="change_password.php" class="list-group-item list-group-item-action"><i class="bi bi-shield-lock me-3"></i>Đổi mật khẩu</a>
                            <a href="logout.php" class="list-group-item list-group-item-action text-danger"><i class="bi bi-power me-3"></i>Thoát ứng dụng</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row g-4 text-center">
                    <div class="col-6 col-sm-3">
                        <a href="deposit.php" class="action-btn d-block">
                            <i class="bi bi-plus-circle text-primary"></i> <span>Nạp tiền</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="withdraw.php" class="action-btn d-block">
                            <i class="bi bi-dash-circle text-danger"></i> <span>Rút tiền</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="transfer.php" class="action-btn d-block">
                            <i class="bi bi-arrow-left-right text-success"></i> <span>Chuyển tiền</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="buy_card.php" class="action-btn d-block">
                            <i class="bi bi-phone text-warning"></i> <span>Mua thẻ ĐT</span>
                        </a>
                    </div>
                </div>

                <div class="card mt-4 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary p-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(to right, #1a73e8, #4285f4) !important;">
                        <div>
                            <h5 class="fw-bold mb-1">Dịch vụ tiện ích</h5>
                            <p class="small mb-0 opacity-75">Nạp tiền, mua thẻ cào chiết khấu cao</p>
                        </div>
                        <i class="bi bi-grid-3x3-gap-fill fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>