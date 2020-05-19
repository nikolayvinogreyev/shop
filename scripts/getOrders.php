<?php

$sth = $dbh->prepare('
    select
        o.id as order_id
    ,   IF(o.second_name IS NULL, CONCAT(o.last_name, \' \', o.first_name), CONCAT(o.last_name, \' \', o.first_name, \' \', o.second_name)) as client_full_name
    ,   o.phone
    ,   o.email
    ,   CONCAT(o.city, \', \', o.street, \' д.\', o.house, \' кв.\', o.flat) as client_full_address
    ,   o.comment_
    ,   o.delivery_type_id
    ,   dt.name as delivery_type_name
    ,   pt.name as payment_type_name
    ,   pr.name as product_name
    ,   concat(replace(format(o.product_price + o.delivery_price, 0), ",", " "), " руб.") as formatted_full_order_price
    ,	o.order_status_id
    ,   os.name as order_status_name
    
    from orders as o
    
    join delivery_types as dt on o.delivery_type_id = dt.id
    join payment_types as pt on o.payment_type_id = pt.id
    join products as pr on o.product_id = pr.id
    join order_statuses as os on o.order_status_id = os.id
    
    order by o.order_status_id desc, o.order_date desc
');

$sth->execute();
$orders = $sth->fetchAll();
