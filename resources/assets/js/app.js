require('./bootstrap');

const numberFormat = require("underscore.string/numberFormat");

$(document).ready(function () {
    $('.page-loader').fadeOut();
});

// Scroll Up
$(window).scroll((e) => {
    if ($(e.currentTarget).scrollTop() > 100) {
        $('.scrollup').fadeIn('slow');
    } else {
        $('.scrollup').fadeOut('slow');
    }
});
$('.scrollup').on('click', 'button', () => {
    $('html, body').animate({
        scrollTop: 0
    }, 800, () => {
        $('.scrollup button').blur();
    });
    return false;
});

window.urlInsertParam = (key, value) => {
    key = escape(key);
    value = escape(value);

    let kvp = document.location.search.substr(1).split('&');
    if (kvp === '') {
        document.location.search = `?${key}=${value}`;
    } else {

        let i = kvp.length;
        let x;
        while (i--) {
            x = kvp[i].split('=');

            if (x[0] === key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }

        document.location.search = kvp.join('&');
    }
};

// Generate shopping cart items
const generateShoppingCartItems = (items) => {
    let result = $('<div></div>');
    items.forEach((item, i, arr) => {
        let $rItem = $(`<div class="row mb-2" data-id="${item.id}"></div>`);
        let $cImage = $(`<div class="col-2"><img src="${item.image}" alt="${item.name}" class="img-thumbnail"></div>`);
        let $cName = $(`<div class="col-5"><span class="text-dark">${item.name}</span></div>`);
        let availableClass = item.available > 0 ? 'text-success' : 'text-danger';
        let availableText = item.available > 0 ? 'В наличии' : 'Отсутствует';
        let $cAvailable = $(`<div class="col-2"><span class="${availableClass}">${availableText}</span></div>`);
        let $cCount = $(`<div class="col-2">Кол-во: <span class="text-dark font-weight-bold">${item.count}</span></div>`);
        let $cBtn = $(`<div class="col-1"><button class="btn btn-danger removeFromCart"><span class="oi oi-trash" title="Убрать из корзины" aria-hidden="true"></span></button></div>`);

        $rItem.append($cImage, $cName, $cCount, $cAvailable, $cBtn);
        result.append($rItem);
    });

    return result;
};

const generateShoppingCartContentItems = (items) => {
    let result = $('<tbody></tbody>');
    items.forEach((item, i, arr) => {
        let $rItem = $(`<tr data-id="${item['id']}"></tr>`);
        let $cNumber = $(`<th scope="row">${i + 1}</th>`);
        let $cImage = $(`<td><img src="${item['image']}" alt="${item['name']}" class="img-thumbnail"></td>`);
        let $cName = $(`<td><a href="/product/${item['slug']}">${item['name']}</a></td>`);
        let $cAvailable = $(`<td><span class="${item['available'] ? 'text-success' : 'text-danger'}">${item['available'] ? 'В наличии' : 'Отсутствует'}</span></td>`);
        let $cPrice = $(`<td>${numberFormat(item['price'], 2, ',', ' ')}&nbsp;&#8381;</td>`);
        let $cProductCount = $(`<td width="100"><div class="btn-group btn-group-sm">` +
            `<button class="btn btn-dark btn-sm" id="productDecrement" data-id="${item['id']}">` +
            `<span class="oi oi-minus" title="Меньше" aria-hidden="true"></span></button>` +
            `<input class="text-center" type="text" id="productCount" value="${item['count']}" readonly style="width:50px;">` +
            `<button class="btn btn-dark btn-sm" id="productIncrement" data-id="${item['id']}">` +
            `<span class="oi oi-plus" title="Больше" aria-hidden="true"></span></button></div></td>`);
        let $cSum = $(`<td>${numberFormat(item['sum'], 2, ',', ' ')}&nbsp;&#8381;</td>`);
        let $cBtn = $(`<td><button id="removeFromCart" class="btn btn-danger">` +
            `<span class="oi oi-trash" title="Убрать из корзины" aria-hidden="true"></span></button></td>`);

        $rItem.append($cNumber, $cImage, $cName, $cAvailable, $cPrice, $cProductCount, $cSum, $cBtn);
        result.append($rItem);
    });

    return result;
};

// Add to shopping cart
$('.addToCart').on('click', (e) => {
    const self = e.currentTarget;
    let productId = $(self).data('id');
    let count = 1;
    let current = parseInt($(self).data('current')) > 0;
    if (current) {
        count = $('#productCount').val();
    }

    $(self).closest('.card').preloader('start');
    $.ajax({
        type: 'POST',
        url: `/ajax-add-to-cart/${productId}`,
        data: {
            count: count,
        }
    })
        .done((response) => {
            // console.log('Success', response);

            window.shoppingCart = response;

            // Update shopping cart count
            let $badge = $('.navbar .shoppingCart .badge');
            $badge.text(response.count);
            $badge.show();

            // Generate content for shopping cart dialog
            $('#shoppingCartModal .modal-body')
                .empty()
                .append(generateShoppingCartItems(response.items));


            // Show shopping cart modal dialog
            $('#shoppingCartModal').modal('show');


        })
        .fail((jqXHR, textStatus) => {
            console.log('Error', textStatus);
        })
        .always(() => {
            $(self).closest('.card').preloader('stop');
        });
});

// Remove from cart
$('#shoppingCartModal').on('click', '.removeFromCart', (e) => {
    const self = e.currentTarget;
    let productId = $(self).closest('.row').data('id');

    $(self).closest('#shoppingCartModal .modal-body').preloader('start');
    $.ajax({
        type: 'POST',
        url: `/ajax-remove-from-cart/${productId}`,
        data: {
            completely: true
        }
    })
        .done((response) => {
            // console.log('Success', response);

            window.shoppingCart = response;

            // Update shopping cart count
            let $badge = $('.navbar .shoppingCart .badge');
            $badge.text(response.count);
            if (response.count > 0) {
                $badge.show();
            } else {
                $badge.show();
            }

            // Generate content for shopping cart dialog
            $('#shoppingCartModal .modal-body').empty();
            if (response.count > 0) {
                $('#shoppingCartModal .modal-body').append(generateShoppingCartItems(response.items));
            } else {
                $('#shoppingCartModal .modal-body').append($('<p class="text-center text-muted">В корзине нет ни одного товара...</p>'));
            }

        })
        .fail((jqXHR, textStatus) => {
            console.log('Error', textStatus);
        })
        .always(() => {
            $(self).closest('#shoppingCartModal .modal-body').preloader('stop');
        });
});


/* Shopping cart */

// Increment product count
$('#shoppingCartProducts').on('click', '#productIncrement', (e) => {
    const self = e.currentTarget;
    let productId = $(self).data('id');
    let count = 1;

    $('#shoppingCartProducts').preloader('start');
    $.ajax({
        type: 'POST',
        url: `/ajax-add-to-cart/${productId}`,
        data: {
            count: count,
        }
    }).done((response) => {
        // console.log('Success', response);

        window.shoppingCart = response;

        // Generate shopping cart content
        $('#shoppingCartContent table tbody')
            .replaceWith(generateShoppingCartContentItems(response.items));

        // Update shopping cart total
        $('#shoppingCartTotal').text(numberFormat(response.total, 2, ',', ' '));

    }).fail((jqXHR, textStatus) => {
        console.log('Error', textStatus);
    }).always(() => {
        $('#shoppingCartProducts').preloader('stop');
    });
});

// Decrement product count
$('#shoppingCartProducts').on('click', '#productDecrement', (e) => {
    const self = e.currentTarget;
    let productId = $(self).data('id');
    let currentCount = parseInt($(self).closest('tr').find('#productCount').val(), 10);
    if (currentCount === 1) return;

    $('#shoppingCartProducts').preloader('start');
    $.ajax({
        type: 'POST',
        url: `/ajax-remove-from-cart/${productId}`
    })
        .done((response) => {
            // console.log('Success', response);

            window.shoppingCart = response;

            // Generate shopping cart content
            if (response.count > 0) {
                $('#shoppingCartContent table tbody').replaceWith(generateShoppingCartContentItems(response.items));
            } else {
                $('#shoppingCartContent')
                    .empty()
                    .append($('<h5 class="text-center text-muted"><span class="oi oi-ban"></span>Ваша корзина пуста</h5>'));
            }

            // Update shopping cart total
            if (response.count > 0) {
                $('#shoppingCartTotal').text(numberFormat(response.total, 2, ',', ' '));
            }

        })
        .fail((jqXHR, textStatus) => {
            console.log('Error', textStatus);
        })
        .always(() => {
            $('#shoppingCartProducts').preloader('stop');
        });
});

// Remove from shopping cart
$('#shoppingCartProducts').on('click', '#removeFromCart', (e) => {
    const self = e.currentTarget;
    let productId = $(self).closest('tr').data('id');

    $('#shoppingCartProducts').preloader('start');
    $.ajax({
        type: 'POST',
        url: `/ajax-remove-from-cart/${productId}`,
        data: {
            completely: true
        }
    })
        .done((response) => {
            // console.log('Success', response);

            window.shoppingCart = response;

            // Generate content for shopping cart dialog
            $('#shoppingCartModal .modal-body').empty();
            if (response.count > 0) {
                $('#shoppingCartModal .modal-body').append(generateShoppingCartItems(response.items));
            } else {
                $('#shoppingCartModal .modal-body').append($('<p class="text-center text-muted">В корзине нет ни одного товара...</p>'));
            }

            // Generate shopping cart content
            if (response.count > 0) {
                $('#shoppingCartContent table tbody').replaceWith(generateShoppingCartContentItems(response.items));
            } else {
                $('#shoppingCartContent')
                    .empty()
                    .append($('<h5 class="text-center text-muted"><span class="oi oi-ban"></span>Ваша корзина пуста</h5>'));
            }

            // Update shopping cart total
            if (response.count > 0) {
                $('#shoppingCartTotal').text(numberFormat(response.total, 2, ',', ' '));
            }

        })
        .fail((jqXHR, textStatus) => {
            console.log('Error', textStatus);
        })
        .always(() => {
            $('#shoppingCartProducts').preloader('stop');
        });
});