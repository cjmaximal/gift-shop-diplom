require('./bootstrap');

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

const urlInsertParam = (key, value) => {
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
    }).done((response) => {
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


    }).fail((jqXHR, textStatus) => {
        console.log('Error', textStatus);
    }).always(() => {
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
        url: `/ajax-remove-from-cart/${productId}`
    }).done((response) => {
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

    }).fail((jqXHR, textStatus) => {
        console.log('Error', textStatus);
    }).always(() => {
        $(self).closest('#shoppingCartModal .modal-body').preloader('stop');
    });
});