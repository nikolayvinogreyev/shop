<?php foreach ($orders as $order): ?>
<li class="order-item page-order__item">
    <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--id">
            <span class="order-item__title">Номер заказа</span>
            <span class="order-item__info order-item__info--id"><?php echo $order['order_id']; ?></span>
        </div>
        <div class="order-item__group">
            <span class="order-item__title">Сумма заказа</span>
            <?php echo $order['formatted_full_order_price']; ?>
        </div>
        <button class="order-item__toggle"></button>
    </div>
    <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--margin">
            <span class="order-item__title">Заказчик</span>
            <span class="order-item__info"><?php echo $order['client_full_name']; ?></span>
        </div>
        <div class="order-item__group">
            <span class="order-item__title">Номер телефона</span>
            <span class="order-item__info"><?php echo $order['phone']; ?></span>
        </div>
        <div class="order-item__group">
            <span class="order-item__title">Способ доставки</span>
            <span class="order-item__info"><?php echo $order['delivery_type_name']; ?></span>
        </div>
        <div class="order-item__group">
            <span class="order-item__title">Способ оплаты</span>
            <span class="order-item__info"><?php echo $order['payment_type_name']; ?></span>
        </div>
        <div class="order-item__group order-item__group--status">
            <span class="order-item__title">Статус заказа</span>
            <span class="order-item__info <?php echo ($order['order_status_id'] == 2 ? 'order-item__info--no' : 'order-item__info--yes'); ?>"><?php echo $order['order_status_name']; ?></span>
            <button class="order-item__btn" data-order_id="<?php echo $order['order_id']; ?>" data-status_id="<?php echo $order['order_status_id']; ?>">Изменить</button>
        </div>
    </div>
    <?php
        // Если тип доставки курьерная доставка, выводим адрес
        if ($order['delivery_type_id'] == 2):
     ?>
    <div class="order-item__wrapper">
        <div class="order-item__group">
            <span class="order-item__title">Адрес доставки</span>
            <span class="order-item__info"><?php echo $order['client_full_address']; ?></span>
        </div>
    </div>
    <?php endif; ?>
    <div class="order-item__wrapper">
        <div class="order-item__group">
            <span class="order-item__title">Комментарий к заказу</span>
            <span class="order-item__info"><?php echo $order['comment_']; ?></span>
        </div>
    </div>
</li>
<?php endforeach; ?>