<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="cdn/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="cdn/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="cdn/usersStyle.css">
</head>

<body>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        unset($_SESSION['verifiedAdmin']);
        header('location: adminLogin.php');
        exit();
    }
    ?>
    <div class="container" style="margin-top: 5px; min-width: 100%;">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark card-header">
            <a class="navbar-brand" href="https://wizard-baba.online/" target="_blank"><i class="fas fa-home mr-2"></i>Admin Panel by <span style="color: red;">Wizort</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="fas fa-user mr-2"></i>Panel </span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addVerifyKey.php"><i class="fas fa-user-plus mr-2"></i>Add key </span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dogrula.php"><i class="fas fa-sign-in-alt mr-2"></i>Login as user </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=logout"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>