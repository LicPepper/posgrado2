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

// Registro de recursos CSS
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Nunito:wght@600;700&display=swap');

// SweetAlert2 para alertas bonitas
$this->registerCssFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css');

// CSS personalizado
$this->registerCss(<<<CSS
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
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

.dropdown-menu {
    border-radius: 0.25rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.dropdown-item:focus, .dropdown-item:hover {
    background-color: #f8f9fa;
    color: var(--primary-color);
}
CSS
);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?> | Sistema de Documentos de Posgrado</title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/tecnm-logo.png', [
            'alt' => 'IT Villahermosa',
            'style' => 'height: 40px; margin-right: 10px;'
        ]) . 'Sistema de Documentos - Posgrado',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark shadow-sm',
        ],
    ]);

    $menuItems = [
        ['label' => '<i class="fas fa-home"></i> Inicio', 'url' => ['/site/index']],
        [
            'label' => '<i class="fas fa-users"></i> Alumnos',
            'items' => [
                ['label' => '<i class="fas fa-list"></i> Listado', 'url' => ['/alumno/index']],
                '<div class="dropdown-divider"></div>',
                ['label' => '<i class="fas fa-plus"></i> Nuevo alumno', 'url' => ['/alumno/create']],
            ],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
        [
            'label' => '<i class="fas fa-user-tie"></i> Revisores',
            'items' => [
                ['label' => '<i class="fas fa-list"></i> Listado', 'url' => ['/revisor/index']],
                '<div class="dropdown-divider"></div>',
                ['label' => '<i class="fas fa-plus"></i> Nuevo revisor', 'url' => ['/revisor/create']],
            ],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
        // MENÚ DE REQUISITOS AGREGADO AQUÍ
        [
            'label' => '<i class="fas fa-list-check"></i> Requisitos',
            'items' => [
                ['label' => '<i class="fas fa-list"></i> Listado', 'url' => ['/requisito/index']],              
                '<div class="dropdown-divider"></div>',
                ['label' => '<i class="fas fa-plus"></i> Crear Nuevo', 'url' => ['/requisito/create']],
            ],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
        [
            'label' => '<i class="fas fa-graduation-cap"></i> Programas',
            'items' => [
                ['label' => '<i class="fas fa-list"></i> Listado', 'url' => ['/programa/index']],
                '<div class="dropdown-divider"></div>',
                ['label' => '<i class="fas fa-plus"></i> Nuevo Programa', 'url' => ['/programa/create']],
            ],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle'],
            'dropDownOptions' => ['class' => 'dropdown-menu']
        ],
    ];

    // Menú para usuarios autenticados
    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => '<i class="fas fa-user-circle"></i> ' . Html::encode(Yii::$app->user->identity->username),
            'items' => [
                [
                    'label' => '<i class="fas fa-user"></i> Mi perfil',
                    'url' => ['/usuario/view', 'id' => Yii::$app->user->id],
                    'linkOptions' => ['class' => 'dropdown-item']
                ],
                [
                    'label' => '<i class="fas fa-cog"></i> Configuración',
                    'url' => ['/usuario/update', 'id' => Yii::$app->user->id],
                    'linkOptions' => ['class' => 'dropdown-item']
                ],
                // Opción de crear usuario solo para administradores
                (Yii::$app->user->identity->puede('crear') ? [
                    'label' => '<i class="fas fa-user-plus"></i> Crear usuario',
                    'url' => ['/usuario/create'],
                    'linkOptions' => ['class' => 'dropdown-item']
                ] : ''),
                '<div class="dropdown-divider"></div>',
                Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
                . Html::submitButton(
                    '<i class="fas fa-sign-out-alt"></i> Cerrar sesión',
                    ['class' => 'dropdown-item btn btn-link']
                )
                . Html::endForm()
            ],
            'options' => ['class' => 'nav-item dropdown'],
            'linkOptions' => ['class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown']
        ];
    } else {
        $menuItems[] = ['label' => '<i class="fas fa-sign-in-alt"></i> Iniciar sesión', 'url' => ['/site/login']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
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

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>