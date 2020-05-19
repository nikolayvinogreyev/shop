<main class="page-products">
    <h1 class="h h--1">Товары</h1>
    <a class="page-products__button button" href="add">Добавить товар</a>
    <div class="page-products__header">
        <span class="page-products__header-field">Название товара</span>
        <span class="page-products__header-field">ID</span>
        <span class="page-products__header-field">Цена</span>
        <span class="page-products__header-field">Категория</span>
        <span class="page-products__header-field">Новинка</span>
    </div>
    <ul class="page-products__list">
        <?php
            if (!empty($products)):
                foreach ($products as $product): ?>
            <li class="product-item page-products__item">
                <b class="product-item__name"><?= $product['name'] ?></b>
                <span class="product-item__field product-item__id"><?= $product['id'] ?></span>
                <span class="product-item__field product-item__price"><?= $product['price'] ?></span>
                <span class="product-item__field product-item__category"><?= $product['category'] ?></span>
                <span class="product-item__field product-item__is_new"><?= $product['is_new'] ?></span>
                <a href="<?= '/edit?id=' . $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
                <button class="product-item__delete"></button>
            </li>
        <?php
                endforeach;
            endif;
        ?>
    </ul>
</main>