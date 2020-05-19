<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getProducts.php');

?>

<?php foreach ($products as $product): ?>
    <article class="shop__item product" data-id="<?php echo $product['id'] ?>" tabindex="0">
        <div class="product__image">
            <img src="<?php echo $product['img_folder'] ?>" alt="<?php echo $product['name'] ?>">
        </div>
        <p class="product__name"><?php echo $product['name'] ?></p>
        <span class="product__price"><?php echo $product['formatted_price'] ?></span>
        <span class="product_id" hidden><?php echo $product['id'] ?></span>
    </article>
<?php endforeach; ?>
