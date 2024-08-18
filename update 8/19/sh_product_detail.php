<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once('nav.php') ?>
<?php include_once('header.php') ?>

<head>
        <style>
            .carousel-indicators {
                position: relative;
                margin-top: 0px;
            }

            .carousel-indicators [data-bs-target] {
                width: 120px;
                height: auto;
                border: none;
            }

            .carousel-indicators img {
                object-fit: contain;
                width: 50%;
                height: 80px;
                border-radius: 5px;
                display: flex;
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                background-color: #757575;
                border-radius: 50%;
                padding: 10px;
            }

            .carousel-item img {
                object-fit: contain;
                width: 100%;
                height: 500px;;
                max-height: 500px;
            }

            .container {
            padding-top: 0; 
        }
        
        
        </style>
    </head>
    <body>
        <!-- Navigation-->
        <?php
        $ids = $_GET['id'];

        if (!isset($ids)) {
            echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
            exit;
        }

        $sql = "SELECT * FROM promodel WHERE pro_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $ids);
        $stmt->execute();
        $promodel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promodel) {
            echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
        } else {
            ?>
        <!-- Product section-->
        <section class="py-1">
            <div class="container px-4 px-lg-5 my-1">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image']); ?>" class="d-block w-100" alt="Main Image">
                                </div>
                                <?php if (!empty($promodel['image2'])): ?>
                                <div class="carousel-item">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image2']); ?>" class="d-block w-100" alt="Image 2">
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($promodel['image3'])): ?>
                                <div class="carousel-item">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image3']); ?>" class="d-block w-100" alt="Image 3">
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($promodel['image4'])): ?>
                                <div class="carousel-item">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image4']); ?>" class="d-block w-100" alt="Image 4">
                                </div>
                                <?php endif; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>

                            <ol class="carousel-indicators justify-content-center">
                                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image']); ?>" class="d-block w-100" alt="Thumbnail 1">
                                </li>
                                <?php if (!empty($promodel['image2'])): ?>
                                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image2']); ?>" class="d-block w-100" alt="Thumbnail 2">
                                </li>
                                <?php endif; ?>
                                <?php if (!empty($promodel['image3'])): ?>
                                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image3']); ?>" class="d-block w-100" alt="Thumbnail 3">
                                </li>
                                <?php endif; ?>
                                <?php if (!empty($promodel['image4'])): ?>
                                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3">
                                    <img src="uploads/<?= htmlspecialchars($promodel['image4']); ?>" class="d-block w-100" alt="Thumbnail 4">
                                </li>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </div>

                    <div class="col-md-6 product-info">
                        <h1 class="display-5 fw-bolder"><?= htmlspecialchars($promodel['pro_name']); ?></h1>
                        <div class="fs-5 mb-5">
                            <span class="text-danger"><b><?= htmlspecialchars($promodel['price']); ?></b> บาท</span>
                        </div>
                        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?</p>
                        <div class="d-flex">
                            <button class="btn btn-outline-dark flex-shrink-0" type="button">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        }
        $conn = null;
        ?>
</body>

<?php include_once('fooster.php') ?>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
