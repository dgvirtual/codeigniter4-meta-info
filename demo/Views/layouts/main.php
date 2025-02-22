<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CodeIgniter 4 App' ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .help-block {
            color: red;
            font-size: 0.8em;
        }
        legend {
        padding-left: 0.5rem;
        margin-top:1rem;
        background: var(--bs-gray-300);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-primary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="/">CI4 Meta Info Demo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/testusers">Testusers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/meta_info">meta_info</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>