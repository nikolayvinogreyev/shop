<main class="page-add">
    <h1 class="h h--1">Добавление товара</h1>
    <form class="custom-form" action="#" method="post">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="product-name" id="product-name"
                       value="<?php echo isset($product['name']) ? $product['name'] : '' ?>">
                <p class="custom-form__input-label">
                    <?php echo isset($product['name']) ? '' : 'Название товара'; ?>
                </p>
            </label>
            <label for="product-price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="product-price" id="product-price"
                       value="<?php echo isset($product['price']) ? $product['price'] : '' ?>">
                <p class="custom-form__input-label">
                    <?php echo isset($product['price']) ? '' : 'Цена товара'; ?>
                </p>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" name="product-photo" id="product-photo" hidden="" required>
                    <label for="product-photo">Добавить фотографию</label>
                </li>
                <?php if (isset($product['img_folder'])): ?>
                    <li class="add-list__item add-list__item--active">
                        <img src="<?php echo $product['img_folder'] ?>">
                    </li>
                <?php endif; ?>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <select name="category[]" class="custom-form__select" multiple="multiple" required>
                    <option hidden="">Название раздела</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($category['product_id']) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="checkbox" name="new" id="new"
                   class="custom-form__checkbox" <?php echo (isset($product['is_new']) && $product['is_new']) ? 'checked' : ''; ?>>
            <label for="new" class="custom-form__checkbox-label">Новинка</label>
            <input type="checkbox" name="sale" id="sale"
                   class="custom-form__checkbox" <?php echo (isset($product['on_sale']) && $product['on_sale']) ? 'checked' : ''; ?>>
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button"
                type="submit"><?php echo(isset($_GET['id']) ? 'Изменить товар' : 'Добавить товар'); ?></button>
    </form>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title"><?php echo(isset($_GET['id']) ? 'Товар успешно изменен' : 'Товар успешно добавлен'); ?></h2>
        </div>
    </section>
</main>