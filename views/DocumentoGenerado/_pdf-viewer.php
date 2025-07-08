<?php
use yii\helpers\Url;
?>

<div class="pdf-viewer-container">
    <!-- Visor PDF embebido -->
    <iframe 
        src="<?= Url::to(['/documento-generado/stream', 'id' => $id]) ?>" 
        style="width:100%; height:80vh; border:none;"
        frameborder="0"
    ></iframe>
</div>

<style>
.pdf-viewer-container {
    padding: 15px;
}
</style>