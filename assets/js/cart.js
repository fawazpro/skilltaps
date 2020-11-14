// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function () {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Constructor
    function Item(name, image, price, count) {
        this.name = name;
        this.image = image;
        this.price = price;
        this.count = count;
    }

    // Save cart
    function saveCart() {
        sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
        cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }
    if (sessionStorage.getItem("shoppingCart") != null) {
        loadCart();
    }


    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};

    // Add to cart
    obj.addItemToCart = function (name, image, price, count) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count++;
                saveCart();
                return;
            }
        }
        var item = new Item(name, image, price, count);
        cart.push(item);
        saveCart();
    }
    // Set count from item
    obj.setCountForItem = function (name, count) {
        for (var i in cart) {
            if (cart[i].name === name) {
                cart[i].count = count;
                break;
            }
        }
    };
    // Remove item from cart
    obj.removeItemFromCart = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count--;
                if (cart[item].count === 0) {
                    cart.splice(item, 1);
                }
                break;
            }
        }
        saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart.splice(item, 1);
                break;
            }
        }
        saveCart();
    }

    // Clear cart
    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    // Count cart 
    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    // Coupon Total 
    obj.couponTotal = function (coupon) {
        var couponDiscount = coupon;
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
        }
        return (Number(totalCart.toFixed(2)) - couponDiscount);
        
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
        }
        return Number(totalCart.toFixed(2));
    }

    // List cart
    obj.listCart = function () {
        var cartCopy = [];
        for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
                itemCopy[p] = item[p];

            }
            itemCopy.total = Number(item.price * item.count).toFixed(2);
            cartCopy.push(itemCopy)
        }
        return cartCopy;
    }

    // cart : Array
    // Item : Object/Class
    // addItemToCart : Function
    // removeItemFromCart : Function
    // removeItemFromCartAll : Function
    // clearCart : Function
    // countCart : Function
    // totalCart : Function
    // couponTotal : Function
    // listCart : Function
    // saveCart : Function
    // loadCart : Function
    return obj;
})();


// *****************************************
// Triggers / Events
// ***************************************** 
// Add item
$('.add-to-cart').click(function (event) {
    event.preventDefault();
    var name = $(this).data('name');
    var image = $(this).data('img');
    var price = Number($(this).data('price'));
    shoppingCart.addItemToCart(name, image, price, 1);
    displayCart();
});

// Clear items
$('.clear-cart').click(function () {
    shoppingCart.clearCart();
    displayCart();
});

function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
        output += "<tr>"
            + "<td>" + cartArray[i].name + "</td>"
            + "<td>(" + cartArray[i].price + ")</td>"
            + "<td><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
            + "<input type='number' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
            + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button></div></td>"
            + "<td><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
            + " = "
            + "<td>" + cartArray[i].total + "</td>"
            + "</tr>";
    }
    $('.show-cart').html(output);
    $('.total-cart').html(shoppingCart.totalCart());
    $('.total-count').html(shoppingCart.totalCount());
    $('.coupon-total').html(shoppingCart.couponTotal());
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
})


// -1
$('.show-cart').on("click", ".minus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCart(name);
    displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.addItemToCart(name);
    displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function (event) {
    var name = $(this).data('name');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
});

function pay() {
    let price = parseInt($('#price').html());
    let wallet = parseInt($('#wallet').html());
    let paybtn = $('#paybtn');

    if(price > wallet){
        paybtn.attr('disabled','');
    }else if(wallet > price){
        paybtn.removeAttr('disabled');
    }
}

function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {

        output += `<div class="card mb-1">
            <div class="card-body py-2 d-flex">
                <button type="button" class="close text-danger delete-item" data-name="${cartArray[i].name}" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img class="img-fluid float-left" src="${cartArray[i].image}" width="20%" alt="" />
                <div class="row">
                <p class="col-12 card-text m-auto">
                    <span class="h4"> ${cartArray[i].name} </span> <br /> &#x20a6;${cartArray[i].price}
                </p>
                <div class="col-6 form-inline input-group">
                    <div class="input-group-prepend">
                        <button class="minus-item btn btn-outline-danger" data-name="${cartArray[i].name}" type="button" id="button-addon1">-</button>
                    </div>
                    <input type="number" class="form-control" data-name="${cartArray[i].name}" value="${cartArray[i].count}" style="">
                    <div class="input-group-append">
                        <button class="plus-item btn btn-outline-success" data-name="${cartArray[i].name}" type="button" id="button-addon2">+</button>
                    </div>
                </div>
                <small class="col-3"></small>
                <span class="col-3 text-success px-1 my-0 font-smaller">&#x20a6;${cartArray[i].total}</small>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>`;

    };
    let order = encodeURIComponent(JSON.stringify(shoppingCart.listCart()));
    let price = shoppingCart.totalCart();
    $('.showCart').html(output);
    $('.total-cart').html(shoppingCart.totalCart());
    $('.total-count').html(shoppingCart.totalCount());
    $('.coupon-total').html(shoppingCart.couponTotal());
    $('#finalprice').html(`<input type='hidden' class='form-control' name='price' value=${price}>`);
    $('#finalorder').html(`<input type='hidden' class='form-control' name='order' value="${order}">`);
    pay();
}

// Delete item button

$('.showCart').on("click", ".delete-item", function (event) {
    var name = $(this).data('name');
    console.log(name);
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
})

// -1
$('.showCart').on("click", ".minus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCart(name);
    displayCart();
})

// Apply Coupon
// $('.showCart').on("click", function (ev) {
//     $('#coupon').submit(function (e) {
//     e.preventDefault();
//     var couponCode = e.delegateTarget[0].value;
//     shoppingCart.couponTotal(couponCode);
//     displayCart();
// });
// })

// Apply Coupon
$('.coupon').on('submit', '#coupon', function (e) {
    e.preventDefault();
    console.log(e);
    var couponCode = e.target[0].value;
    // shoppingCart.couponTotal(couponCode);
    refreshCoupon(couponCode);
});

// +1
$('.showCart').on("click", ".plus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.addItemToCart(name);
    displayCart();
})

// Item count input
$('.showCart').on("change", ".item-count", function (event) {
    var name = $(this).data('name');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
});

displayCart();
// refreshCoupon('');
