<?php

/** @var yii\web\View $this */
/** @var app\models\Peliculas[] $peliculas */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'My Movie App';

// Select first 5 movies for the slider
$sliderMovies = array_slice($peliculas, 0, 5);
?>

<style>
    /* Custom Styles for Netflix-like feel */
    .hero-slider .carousel-item {
        height: 80vh;
        min-height: 500px;
        background-color: #000;
        position: relative;
    }
    .hero-slider .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(20,20,20,0.3) 0%, rgba(20,20,20,0) 20%, rgba(20,20,20,0) 60%, rgba(20,20,20,1) 100%),
                    linear-gradient(to right, rgba(20,20,20,0.8) 0%, rgba(20,20,20,0) 50%);
    }
    .hero-caption {
        bottom: 20%;
        left: 5%;
        text-align: left;
        max-width: 600px;
        z-index: 2;
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        margin-bottom: 1rem;
    }
    .hero-desc {
        font-size: 1.2rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        margin-bottom: 2rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .movie-section {
        padding: 3rem 5%;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #e5e5e5;
    }
    
    .movie-card {
        transition: transform 0.3s ease, z-index 0.3s;
        cursor: pointer;
        position: relative;
        border: none;
        background: transparent;
    }
    .movie-card:hover {
        transform: scale(1.1);
        z-index: 10;
    }
    .movie-poster {
        border-radius: 4px;
        width: 100%;
        aspect-ratio: 2/3;
        object-fit: cover;
    }
    .movie-info {
        opacity: 0;
        transition: opacity 0.3s;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    }
    .movie-card:hover .movie-info {
        opacity: 1;
    }
    .movie-title {
        font-size: 0.9rem;
        font-weight: bold;
        color: #fff;
        margin: 0;
    }
</style>

<!-- Hero Slider -->
<?php if (!empty($sliderMovies)): ?>
<div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($sliderMovies as $index => $movie): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($sliderMovies as $index => $movie): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <?php 
                    $imgUrl = $movie->portada ? Url::to('@web/portadas/' . $movie->portada) : 'https://via.placeholder.com/1920x1080?text=No+Image';
                ?>
                <img src="<?= $imgUrl ?>" class="d-block w-100" alt="<?= Html::encode($movie->titulo) ?>">
                <div class="hero-overlay"></div>
                <div class="carousel-caption hero-caption d-none d-md-block">
                    <h1 class="hero-title"><?= Html::encode($movie->titulo) ?></h1>
                    <p class="hero-desc"><?= Html::encode($movie->sinipsis) ?></p>
                    <a href="<?= Url::to(['peliculas/view', 'id_peliculas' => $movie->id_peliculas]) ?>" class="btn btn-light btn-lg px-4 fw-bold"><i class="bi bi-play-fill"></i> Ver Detalles</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php else: ?>
    <div class="container mt-5 text-center">
        <h2>No hay peliculas destacadas</h2>
    </div>
<?php endif; ?>

<!-- Movie Grid -->
<div class="movie-section">
    <h2 class="section-title">Agregadas Recientemente</h2>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
        <?php foreach ($peliculas as $movie): ?>
            <div class="col">
                <a href="<?= Url::to(['peliculas/view', 'id_peliculas' => $movie->id_peliculas]) ?>" class="text-decoration-none">
                    <div class="card movie-card">
                        <?php 
                            $imgUrl = $movie->portada ? Url::to('@web/portadas/' . $movie->portada) : 'https://via.placeholder.com/300x450?text=No+Image';
                        ?>
                        <img src="<?= $imgUrl ?>" class="movie-poster" alt="<?= Html::encode($movie->titulo) ?>">
                        <div class="movie-info">
                            <p class="movie-title"><?= Html::encode($movie->titulo) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>