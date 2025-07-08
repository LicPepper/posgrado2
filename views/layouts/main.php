<?php
/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'
]);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico')
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?> | Sistema de Documentos de Posgrado</title>
    <?php
    // Fuentes e iconos
    $this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    $this->registerCssFile('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Nunito:wght@600;700&display=swap');
    
    // CSS personalizado
    $this->registerCss(<<<CSS
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
    }
    
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f5f7fa;
    }
    
    .navbar-brand {
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
    }
    
    .main-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        padding: 25px;
        margin-top: 20px;
    }
    
    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .bg-primary {
        background-color: var(--primary-color) !important;
    }
    
    /* Estilos para el menú desplegable */
    .dropdown-menu {
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .dropdown-item:focus, .dropdown-item:hover {
        background-color: #f8f9fa;
        color: var(--primary-color);
    }
    
    /* Mejoras para el breadcrumb */
    .breadcrumb {
        background-color: transparent;
        padding: 0.5rem 0;
    }
    
    /* Estilos para las tarjetas */
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 20px;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
CSS
    );
    
    $this->head();
    ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo-itvh.png', [
            'alt' => 'IT Villahermosa',
            'style' => 'height: 40px; margin-right: 10px;'
        ]) . 'Sistema de Documentos - Posgrado',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark shadow-sm',
        ],
    ]);

    // Elementos del menú principal
    $menuItems = [
        [
            'label' => '<i class="fas fa-home"></i> Inicio',
            'url' => ['/site/index'],
            'linkOptions' => ['class' => 'nav-link']
        ],
        [
            'label' => '<i class="fas fa-users"></i> Alumnos',
            'items' => [
                ['label' => '<i class="fas fa-list"></i> Listado', 'url' => ['/alumno/index']],
                ['label' => '<i class="fas fa-search"></i> Buscar', 'url' => ['/alumno/buscar']],
                '<div class="dropdown-divider"></div>',
                
            ],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
        
        [
            'label' => '<i class="fas fa-cog"></i> Configuración',
            'items' => [
                ['label' => '<i class="fas fa-graduation-cap"></i> Programas', 'url' => ['/programa/index']],
                ['label' => '<i class="fas fa-tasks"></i> Requisitos', 'url' => ['/requisito/index']],
                '<div class="dropdown-divider"></div>',
                ['label' => '<i class="fas fa-users-cog"></i> Usuarios', 'url' => ['/usuario/index']],
            ],
            'visible' => Yii::$app->user->can('administrador'),
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
    ];

    // Elementos del menú derecho (usuario)
    $rightMenuItems = [
        Yii::$app->user->isGuest ? (
            ['label' => '<i class="fas fa-sign-in-alt"></i> Iniciar sesión', 'url' => ['/site/login']]
        ) : (
            '<li class="nav-item dropdown">'
            . Html::a(
                '<i class="fas fa-user-circle"></i> ' . Html::encode(Yii::$app->user->identity->username),
                '#',
                [
                    'class' => 'nav-link dropdown-toggle',
                    'data-bs-toggle' => 'dropdown',
                    'aria-expanded' => 'false',
                    'id' => 'userDropdown'
                ]
            )
            . '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">'
            . Html::a(
                '<i class="fas fa-user"></i> Mi perfil',
                ['/usuario/view', 'id' => Yii::$app->user->id],
                ['class' => 'dropdown-item']
            )
            . Html::a(
                '<i class="fas fa-cog"></i> Configuración',
                ['/usuario/update', 'id' => Yii::$app->user->id],
                ['class' => 'dropdown-item']
            )
            . '<div class="dropdown-divider"></div>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
            . Html::submitButton(
                '<i class="fas fa-sign-out-alt"></i> Cerrar sesión',
                ['class' => 'dropdown-item']
            )
            . Html::endForm()
            . '</div>'
            . '</li>'
        )
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $rightMenuItems,
        'encodeLabels' => false,
    ]);

    NavBar::end();
    ?>
</header>

<main class="flex-shrink-0">
    <div class="container py-4">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
            'homeLink' => [
                'label' => '<i class="fas fa-home"></i> Inicio',
                'url' => Yii::$app->homeUrl,
                'encode' => false
            ],
            'options' => ['class' => 'breadcrumb mb-4'],
            'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
            'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n"
        ]) ?>

        <?= \app\widgets\Alert::widget() ?>

        <div class="main-container">
            <?= $content ?>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">
                    &copy; <?= date('Y') ?> Instituto Tecnológico de Villahermosa - Departamento de Posgrado
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">
                    Versión <?= Yii::$app->version ?> | 
                    <i class="fas fa-code-branch"></i> <?= @exec('git rev-parse --short HEAD') ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>