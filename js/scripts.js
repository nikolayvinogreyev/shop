'use strict';

const toggleHidden = (...fields) => {

    fields.forEach((field) => {

        if (field.hidden === true) {

            field.hidden = false;

        } else {

            field.hidden = true;

        }
    });
};

const labelHidden = (form) => {

    form.addEventListener('focusout', (evt) => {

        const field = evt.target;
        const label = field.nextElementSibling;

        if (field.tagName === 'INPUT' && field.value && label) {

            label.hidden = true;

        } else if (label) {

            label.hidden = false;

        }
    });
};

const toggleDelivery = (elem) => {

    const delivery = elem.querySelector('.js-radio');
    const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
    const deliveryNo = elem.querySelector('.shop-page__delivery--no');
    const fields = deliveryYes.querySelectorAll('.custom-form__input');

    delivery.addEventListener('change', (evt) => {

        if (evt.target.id === 'dev-no') {

            fields.forEach(inp => {
                if (inp.required === true) {
                    inp.required = false;
                }
            });


            toggleHidden(deliveryYes, deliveryNo);

            deliveryNo.classList.add('fade');
            setTimeout(() => {
                deliveryNo.classList.remove('fade');
            }, 1000);

        } else {

            fields.forEach(inp => {
                if (inp.required === false) {
                    inp.required = true;
                }
            });

            toggleHidden(deliveryYes, deliveryNo);

            deliveryYes.classList.add('fade');
            setTimeout(() => {
                deliveryYes.classList.remove('fade');
            }, 1000);
        }
    });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

    filterWrapper.addEventListener('click', evt => {

        const filterList = filterWrapper.querySelectorAll('.filter__list-item');

        filterList.forEach(filter => {

            if (filter.classList.contains('active')) {

                filter.classList.remove('active');

            }

        });

        const filter = evt.target;

        filter.classList.add('active');

    });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

    shopList.addEventListener('click', (evt) => {

        const prod = evt.path || (evt.composedPath && evt.composedPath());
        ;

        if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

            const shopOrder = document.querySelector('.shop-page__order');
            // Получаем id товара
            let productId = prod[0].getAttribute('data-id');

            toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

            evt.preventDefault();

            window.scroll(0, 0);

            shopOrder.classList.add('fade');
            setTimeout(() => shopOrder.classList.remove('fade'), 1000);

            const form = shopOrder.querySelector('.custom-form');
            labelHidden(form);

            toggleDelivery(shopOrder);

            const buttonOrder = shopOrder.querySelector('.button');
            const popupEnd = document.querySelector('.shop-page__popup-end');

            buttonOrder.addEventListener('click', (evt) => {

                form.noValidate = true;

                const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

                inputs.forEach(inp => {

                    if (!!inp.value) {

                        if (inp.classList.contains('custom-form__input--error')) {
                            inp.classList.remove('custom-form__input--error');
                        }

                    } else {

                        inp.classList.add('custom-form__input--error');

                    }
                });

                if (inputs.every(inp => !!inp.value)) {

                    evt.preventDefault();

                    let formData = new FormData();
                    formData.append('formData', decodeURI(($('form').serialize())));
                    formData.append('productId', productId);

                    // Вызов скрипта вставки заказа в БД
                    $.ajax({
                        url: '/scripts/insertOrder.php',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (data) {
                            // Если данные успешно записаны, вызываем popup, иначе alert с ошибкой
                            if (data == 1) {
                                toggleHidden(shopOrder, popupEnd);

                                popupEnd.classList.add('fade');
                                setTimeout(() => popupEnd.classList.remove('fade'), 1000);

                                window.scroll(0, 0);

                                const buttonEnd = popupEnd.querySelector('.button');

                                buttonEnd.addEventListener('click', () => {

                                    popupEnd.classList.add('fade-reverse');

                                    setTimeout(() => {

                                        popupEnd.classList.remove('fade-reverse');

                                        toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

                                    }, 1000);
                                });
                            } else {
                                alert('Заполните правильно поля формы');
                            }
                        }
                    });
                } else {
                    window.scroll(0, 0);
                    evt.preventDefault();
                }
            });
        }
    });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

    pageOrderList.addEventListener('click', evt => {


        if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
            var path = evt.path || (evt.composedPath && evt.composedPath());
            Array.from(path).forEach(element => {

                if (element.classList && element.classList.contains('page-order__item')) {

                    element.classList.toggle('order-item--active');

                }

            });

            evt.target.classList.toggle('order-item__toggle--active');

        }

        if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

            const status = evt.target.previousElementSibling;

            if (status.classList && status.classList.contains('order-item__info--no')) {
                status.textContent = 'Выполнено';
            } else {
                status.textContent = 'Не выполнено';
            }

            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');

        }

    });

    // Здесь будет код по изменению статуса заказа
    $('.order-item__btn').click(function (event) {
        $.ajax({
            url: '/scripts/updateOrderStatus.php',
            type: 'post',
            data: {'orderId': $(this).attr('data-order_id'), 'statusId': $(this).attr('data-status_id') == 1 ? 2 : 1},
        })
    });
}

const checkList = (list, btn) => {

    if (list.children.length === 1) {

        btn.hidden = false;

    } else {
        btn.hidden = true;
    }

};

const addList = document.querySelector('.add-list');


if (addList) {

    const form = document.querySelector('.custom-form');
    labelHidden(form);

    const addButton = addList.querySelector('.add-list__item--add');
    const addInput = addList.querySelector('#product-photo');

    checkList(addList, addButton);

    $('.add-list__item.add-list__item--active').click(function (event) {
        addList.removeChild(event.target);
        addInput.value = '';
        checkList(addList, addButton);
    });

    addInput.addEventListener('change', evt => {

        const template = document.createElement('LI');
        const img = document.createElement('IMG');

        template.className = 'add-list__item add-list__item--active';
        template.addEventListener('click', evt => {
            addList.removeChild(evt.target);
            addInput.value = '';
            checkList(addList, addButton);
        });

        const file = evt.target.files[0];
        const reader = new FileReader();

        reader.onload = (evt) => {
            img.src = evt.target.result;
            template.appendChild(img);
            addList.appendChild(template);
            checkList(addList, addButton);
        };

        reader.readAsDataURL(file);

    });

    const button = document.querySelector('.button');
    const popupEnd = document.querySelector('.page-add__popup-end');

    // Код для загрузки нового товара в БД
    button.addEventListener('click', (evt) => {

        evt.preventDefault();

        let formData = new FormData();

        formData.append('file', $("#product-photo")[0].files[0]);
        formData.append('formData', decodeURI($('form').serialize()));

        if (!window.location.search.match(/id=[0-9]+/)) {
            $.ajax({
                url: '/scripts/insertProduct.php',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    if (data == 1) {
                        form.hidden = true;
                        popupEnd.hidden = false;
                    } else {
                        alert('Заполните правильно поля формы!');
                    }
                }
            });
        } else {
            $.ajax({
                url: '/scripts/updateProduct.php',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    if (data == 1) {
                        form.hidden = true;
                        popupEnd.hidden = false;
                    } else {
                        alert('Заполните правильно поля формы!');
                    }
                }
            });
        }
    });

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

    productsList.addEventListener('click', evt => {

        const target = evt.target;

        if (target.classList && target.classList.contains('product-item__delete')) {

            let id = target.parentElement.querySelector('.product-item__id').textContent;
            // Удаление товара
            $.ajax({
                url: '/scripts/removeProduct.php',
                type: 'POST',
                data: {'id': id}
            });
            productsList.removeChild(target.parentElement);
        }
    });
}

// Функция для форматирования числа с разделителями
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')
}

// jquery range maxmin
if (document.querySelector('.shop-page')) {
    // Формируем максимальное и минимальное значение для слайдера
    let minPrice = parseFloat($('.min-price').attr('data-price'));
    let maxPrice = parseFloat($('.max-price').attr('data-price'));

    // Задаем значения минимальной и максимальной цены,
    // которые будем изменять при изменении слайдера
    let sliderMinPrice = minPrice;
    let sliderMaxPrice = maxPrice;
    let sliderChange = false;

    $('.range__line').slider({
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        range: true,
        stop: function (event, ui) {

            $('.min-price').text(formatNumber($('.range__line').slider('values', 0)) + ' руб.');
            $('.max-price').text(formatNumber($('.range__line').slider('values', 1)) + ' руб.');

            sliderMinPrice = $('.range__line').slider('values', 0);
            sliderMaxPrice = $('.range__line').slider('values', 1);
            sliderChange = true;

        },
        slide: function (event, ui) {

            $('.min-price').text(formatNumber($('.range__line').slider('values', 0)) + ' руб.');
            $('.max-price').text(formatNumber($('.range__line').slider('values', 1)) + ' руб.');

        }
    });

    // Подстветка текущей страницы в меню
    let currentUrl = window.location.pathname;
    let currentFilterUrl = window.location.search;

    $('a[href$="' + currentUrl + '"]').addClass('active');
    $('a[href$="' + currentFilterUrl + '"]').addClass('active');

    let category = document.location.pathname.replace('/', '');

    function setPageOptions(params) {
        return function (event) {
            event.preventDefault();
            let page = $(this).attr('href');
            $.get({
                url: '/templates/index/indexProductsTemplate.php',
                data: params + '&page=' + page,
                success: function (data) {
                    console.log(params);
                    $('.shop__list').html(data);
                }
            });
            let url = document.location.href.replace(/[?, &]page=[0-9]+/, '');
            if (url.includes('?')) {
                history.replaceState(null, null, url + '&page=' + page);
            } else {
                history.replaceState(null, null, url + '?page=' + page);
            }
        }
    }

    // Фильтр товаров и пагинация
    $('#filter').submit(function (event) {
        event.preventDefault();

        let orderBy = $('.custom-form__select[name=orderBy] option:selected').attr('value');
        let orderType = $('.custom-form__select[name=orderType] option:selected').attr('value');

        if (orderBy != undefined && orderType != undefined) {
            $('input[name=orderBy]').remove();
            $('input[name=orderType]').remove();

            $(this).append('<input type="hidden" name="orderBy" value="' + orderBy + '">');
            $(this).append('<input type="hidden" name="orderType" value="' + orderType + '">');
        }

        // Поля для отправки значения максимальной и минимальной цены задаем только в том случае,
        // если были изменены значения в слайдере
        if (sliderChange) {
            // Перед добавлением полей с ценами удаляем их
            $('input[name=minPrice]').remove();
            $('input[name=maxPrice]').remove();
            // Добавляем поля с ценами
            $(this).append('<input type="hidden" name="minPrice" value="' + sliderMinPrice + '">');
            $(this).append('<input type="hidden" name="maxPrice" value="' + sliderMaxPrice + '">');
        }

        // Формируем строку из заполненных данных формы для передачи по ajax
        let formData = $(this).serialize();
        // Вносим данные формы в get параметры url
        history.replaceState(null, null, '?' + formData);
        // Добавляем текущую категорию
        formData = formData + '&category=' + category

        $.ajax({
            url: '/scripts/index/getContentAjax.php',
            method: 'get',
            data: formData,
            success: function (data) {
                let contents = $.parseJSON(data);
                $('.shop__list').html(contents.products);
                $('.shop__paginator').html(contents.pagination);
                $('.res-sort').html(contents.productsCount);
                sliderChange = false;
                $('.paginator__item').click(setPageOptions(formData));
            }
        });
    });

    $('.paginator__item').click(setPageOptions('category=' + category));
}




