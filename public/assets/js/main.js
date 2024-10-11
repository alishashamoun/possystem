
$(document).ready(function () {
    console.log("Document is ready!");

    const productListBody = $('#product-list-body');
    const receiptProducts = $('#receipt-products');

    // Global variable to track total products
    let totalProducts = 0;

    // Function to update receipt section
    function updateReceipt(product) {
        console.log("Product being updated: ", product); // Debug log

        let existingProduct = $(`#receipt-products .receipt-item[data-product-id='${product.id}']`);

        if (existingProduct.length) {
            // Update quantity and subtotal if the product already exists in the receipt
            let quantityElem = existingProduct.find('.receipt-product-quantity');
            let currentQuantity = parseFloat(quantityElem.text()); // Get the current quantity
            let newQuantity = currentQuantity + 1; // Increment by 1

            quantityElem.text(newQuantity.toFixed(2) + ' Pc'); // Update the quantity in the receipt with "Pc"

            // Update subtotal
            let subtotalElem = existingProduct.find('.receipt-subtotal');
            let newSubtotal = (product.price * newQuantity).toFixed(2); // Recalculate subtotal
            subtotalElem.text(`RS ${newSubtotal}`);

        } else {
            // If the product doesn't exist, add it to the receipt
            const receiptItem = `
            <div class="receipt-item" data-product-id="${product.id}">
                <div class="receipt-product-details">
                    <span class="receipt-product-name">${product.name}</span><br />
                    <span class="receipt-product-price">RS ${product.price.toFixed(2)}</span> x
                    <span class="receipt-product-quantity">1.00 Pc</span> <!-- Initial quantity set to 1 -->
                    <span class="receipt-subtotal">RS ${product.price.toFixed(2)}</span>
                </div>
            </div>
            <div class="receipt-item-separator"></div>`;

            // Append new product and separator
            $('#receipt-products').append(receiptItem);
        }

        // Update total products count
        totalProducts += 1; // Increment total products by 1
        $('#total-products').text(totalProducts.toFixed(2)); // Display updated total
        updateTotals(); // Call function to update totals
    }



    function updateLocalStorage() {
        let products = [];
        $('#receipt-products .receipt-item').each(function () {
            let productId = $(this).data('product-id');
            let productName = $(this).find('.receipt-product-name').text();
            let productPrice = parseFloat($(this).find('.receipt-product-price').text().replace('RS ', ''));
            let productQuantity = parseFloat($(this).find('.receipt-product-quantity').text());

            products.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: productQuantity
            });
        });

        localStorage.setItem('receiptProducts', JSON.stringify(products));
    }


    $(document).on('click', '.increase-btn', function () {
        let productRow = $(this).closest('tr');
        let quantityElem = productRow.find('.quantity');
        let newQuantity = parseInt(quantityElem.text()) + 1;
        quantityElem.text(newQuantity);

        // Update subtotal
        updateSubtotal(productRow);
        updateTotals();
    });

    $(document).on('click', '.decrease-btn', function () {
        let productRow = $(this).closest('tr');
        let quantityElem = productRow.find('.quantity');
        let newQuantity = parseInt(quantityElem.text()) - 1;

        if (newQuantity > 0) {
            quantityElem.text(newQuantity);
            updateSubtotal(productRow);
            updateTotals();
        }
    });

    // Add product to list on image click
    $('.product-image img').on('click', function () {
        const productId = $(this).data('product-id');
        const productName = $(this).data('product-name');
        const productPrice = parseFloat($(this).data('product-price'));

        let productRow = $(`#product-list-body tr[data-product-id='${productId}']`);

        if (productRow.length) {
            // If product row exists, update the quantity
            let quantityElem = productRow.find('.quantity');
            let newQuantity = parseInt(quantityElem.text()) + 1;
            quantityElem.text(newQuantity);

            updateSubtotal(productRow);
        } else {
            // If product row does not exist, add new row
            const newRow = `
                <tr data-product-id="${productId}">
                    <td>${productName}</td>
                    <td>
                        <button class="decrease-btn">-</button>
                        <span class="quantity">1</span>
                        <button class="increase-btn">+</button>
                    </td>
                    <td>RS ${productPrice.toFixed(2)}</td>
                    <td class="subtotal">RS ${productPrice.toFixed(2)}</td>
                    <td><button class="delete-btn"><i class="fa-solid fa-trash"></i></button></td>
                </tr>`;
            $('#product-list-body').append(newRow);
        }

        let quantity = parseInt(productRow.find('.quantity').text()) || 1;

        // Update the receipt section
        let productData = {
            id: productId,
            name: productName,
            quantity: quantity,
            price: productPrice,
            subtotal: productPrice * quantity
        };
        updateReceipt(productData);

        updateLocalStorage();

        // Update totals after adding/updating the product
        updateTotals();

        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('.delete-btn');

        // Add click event listener to each delete button
        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                // Get the row of the button that was clicked
                const row = e.target.closest('tr');
                // Remove the row from the table
                if (row) {
                    row.remove();
                }
            });
        });
    });


    // Update subtotal function
    function updateSubtotal(productRow) {
        const price = parseFloat(productRow.find('td:nth-child(3)').text().replace('RS', '').trim()) || 0;
        const quantity = parseInt(productRow.find('.quantity').text()) || 1;
        const subtotal = price * quantity;
        productRow.find('.subtotal').text('RS ' + subtotal.toFixed(2));
    }

    // Function to update totals based on product list
    function updateTotals() {
        let totalQty = 0,
            subTotal = 0;

        // Calculate total quantity and subtotal
        $('#product-list-body tr').each(function () {
            let quantity = parseInt($(this).find('.quantity').text().trim()) || 0;
            let subtotal = parseFloat($(this).find('.subtotal').text().replace('RS', '').trim()) || 0;

            totalQty += quantity;
            subTotal += subtotal;
        });

        let totalAmount = subTotal;

        // Get input values
        let taxPercent = parseFloat($('#tax-input').val()) || 0;
        let discount = parseFloat($('#discount-input').val()) || 0;
        let shipping = parseFloat($('#shipping-input').val()) || 0;

        // Calculate tax amount directly
        let taxAmount = totalAmount * (taxPercent / 100);

        // Calculate grand total
        let grandTotal = totalAmount + taxAmount - discount + shipping;

        // Debugging output
        console.log('Total Amount:', totalAmount);
        console.log('Tax Percent:', taxPercent);
        console.log('Tax Amount:', taxAmount);
        console.log('Discount:', discount);
        console.log('Shipping:', shipping);
        console.log('Grand Total:', grandTotal);

        // Update the DOM with calculated values
        $('#total-qty').text(totalQty);
        $('#sub-total').text('RS ' + subTotal.toFixed(2));
        $('#total-price').text('RS ' + totalAmount.toFixed(2));
        $('#total-products').text(totalQty); // Assuming total products is same as totalQty
        $('#total-amount').text('RS ' + totalAmount.toFixed(2));
        $('#order-tax').text('RS ' + taxAmount.toFixed(2)); // Display calculated tax amount
        $('#discount-display').text('RS ' + discount.toFixed(2));
        $('#shipping-display').text('RS ' + shipping.toFixed(2));

        // Update the displayed grand total text
        $('#grand-total').text('RS ' + grandTotal.toFixed(2));

        // Set the grand total value in the hidden input field
        $('#grand_total').val(grandTotal.toFixed(2));
        $('#paying-amount').val(grandTotal.toFixed(2));
    }

    // Attach event handlers to input fields
    $('#tax-input, #discount-input, #shipping-input').on('input', updateTotals);

    // Initial calculation
    updateTotals();


    // if no product add then error message is displayed
    $('#pay-now-btn').on('click', function (e) {
        var rowCount = $('#product-list-body tr').length;
        if (rowCount === 0) {
            e.preventDefault(); // Prevent further action
            var errorMessage = "Please add products to the cart before proceeding.";

            if (errorMessage) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.error(errorMessage);

            }
        } else {
            // Code to proceed with payment
            var successMessage = "Processing payment...";

            if (successMessage) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success(successMessage);

            }
        }
    });


    function setPaidAmount() {
        var payingAmount = $('#paying-amount').val();
        $('#paid').val(payingAmount);
    }


    // payment processing
    $('#paymentForm').on('submit', function (event) {
        event.preventDefault();
        setPaidAmount();

        var formData = $(this).serialize();
        console.log('Form Data:', formData);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log('Response:', response);
                if (response.success) {
                    toastr.success(response.message);

                    var exampleModal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                    if (exampleModal) {
                        exampleModal.hide();
                    }

                    var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    receiptModal.show();

                    clearProductList();


                } else {
                    toastr.error(response.message || 'An error occurred.');
                }
            },
            error: function (xhr, status, error) {
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
                console.log('Response Text:', xhr.responseText); // Ye line check karein
                toastr.error('An error occurred. Please try again.');
            }

        });
    });



    // Function to clear the product list
    function clearProductList() {
        const productList = document.getElementById('product-list-body');
        if (productList) {
            productList.innerHTML = '';
        }
    }

    // Receipt ko clear karne ka function
    function clearReceipt() {
        $('#receipt-td-total-amount').text('0.00');
        $('#receiptChangeReturn').text('0.00');
        $('#receipt-order-tax').text('0.00');
        $('#receipt-discount').text('0.00');
        $('#receipt-grand-total').text('0.00');
        $('#amount-paid').text('0.00');
        $('#table-td-total-amount').text('0.00');
        $('#change-return-display').text('0.00');
        $('#receipt-products').empty();
    }

    $('.clear-receipt[data-bs-dismiss="modal"]').on('click', function() {
        clearReceipt();
    });

     // Function to clear totals
     function clearTotals() {
        $('#total-qty').text('0');
        $('#sub-total').text('0.00');
        $('#total-price').text('0.00');
    }

    // Payment submit button click event
    $('#paymentsubmit').on('click', function() {
        clearTotals();

    });
});



function calculateChangeReturn() {
    const receivedAmountInput = document.getElementById('received_amount');
    const payingAmountInput = document.getElementById('paying-amount');
    const changeReturnInput = document.getElementById('change-return');

    if (receivedAmountInput && payingAmountInput && changeReturnInput) {
        const receivedAmount = parseFloat(receivedAmountInput.value) || 0;
        const payingAmount = parseFloat(payingAmountInput.value) || 0;
        const change = receivedAmount - payingAmount;

        changeReturnInput.value = change > 0 ? change.toFixed(2) : '0.00';
    }
}




// Reset button functionality
$('#reset-btn').on('click', function (event) {
    event.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03c1fd",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, reset it!",
    }).then((result) => {
        if (result.isConfirmed) {

            $('#product-list-body').empty();

            $('#total-qty').text('0');
            $('#sub-total').text('RS 0.00');
            $('#total-price').text('RS 0.00');
            $('#tax-input').text('RS 0.00');
            $('#discount-input').text('RS 0.00');
            $('#shipping-input').text('RS 0.00');
        }
    });
});

// if no product add so error display
var productsInCart = [];

// Function to add a product row
function addProductRow(product) {
    var rowHtml = `<tr>
                    <td>${product.name}</td>
                    <td>${product.quantity}</td>
                    <td>${product.price}</td>
                </tr>`;
    $('#product-list-body').append(rowHtml);
    productsInCart.push(product);
    localStorage.setItem('productsInCart', JSON.stringify(productsInCart));
}

// Event listener for product image click
$('#product-image').on('click', function () {
    var newProduct = {
        name: 'Sample Product',
        quantity: 1,
        price: 100
    };
    addProductRow(newProduct);
});

// Load products from localStorage
var storedProducts = localStorage.getItem('productsInCart');
if (storedProducts) {
    productsInCart = JSON.parse(storedProducts);
    $.each(productsInCart, function (index, product) {
        addProductRow(product);
    });
}




//  full screen
const fullscreenBtn = document.getElementById('fullscreen-btn');
if (fullscreenBtn) {
    fullscreenBtn.addEventListener('click', function () {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            document.documentElement.requestFullscreen();
        }
    });
}

// search the product
$('#search-input').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    $('.product-card').filter(function () {
        $(this).toggle($(this).find('.product-name').text().toLowerCase().indexOf(
            value) > -1);
    });
});
$('.category-btn').click(function () {
    var category = $(this).data('filter');
    $('.category-btn').removeClass('active');
    $(this).addClass('active');

    if (category == 'all') {
        $('.product-card').show();
    } else {
        $('.product-card').hide();
        $('.product-card[data-category="' + category + '"]').show();
    }
});
$('.brand-btn').click(function () {
    var brand = $(this).data('filter');
    $('.brand-btn').removeClass('active');
    $(this).addClass('active');

    if (brand == 'all') {
        $('.product-card').show();
    } else {
        $('.product-card').hide();
        $('.product-card[data-brand="' + brand + '"]').show();
    }
});

// when clicking on btn
const categoryButtons = document.querySelectorAll('.category-btn');
const brandButtons = document.querySelectorAll('.brand-btn');
const productCards = document.querySelectorAll('.product-card');

let selectedCategory = 'all';
let selectedBrand = 'all';

// Category button event listeners
categoryButtons.forEach(button => {
    button.addEventListener('click', function () {
        selectedCategory = this.getAttribute('data-filter');
        filterProducts();
    });
});

// Brand button event listeners
brandButtons.forEach(button => {
    button.addEventListener('click', function () {
        selectedBrand = this.getAttribute('data-filter');
        filterProducts();
    });
});

function filterProducts() {
    productCards.forEach(card => {
        const productCategory = card.getAttribute('data-category').toLowerCase();
        const productBrand = card.getAttribute('data-brand').toLowerCase();

        const categoryMatch = selectedCategory === 'all' || productCategory === selectedCategory
            .toLowerCase();
        const brandMatch = selectedBrand === 'all' || productBrand === selectedBrand
            .toLowerCase();

        if (categoryMatch && brandMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
filterProducts();



// image preview
function addProduct(productId) {
    var productList = document.getElementById('product-list');
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'products[]'; // Array format for multiple products
    input.value = productId;
    productList.appendChild(input);
}




// current date
const dateElement = document.getElementById('current-date');

if (dateElement) {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    dateElement.textContent = formattedDate;
}

function openModal() {
    var shoppingModal = new bootstrap.Modal(document.getElementById('shoppingModal'));
    shoppingModal.show();
}


// Function to get the current date in register details
function getCurrentDate() {
    var today = new Date();

    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var date = today.getDate() + ' ' + monthNames[today.getMonth()] + ' ' + today.getFullYear();
    return date;
}

// Update the text with the current date
// document.getElementById('register-details').innerHTML = 'Register Details (' + getCurrentDate() + ')';



function updateRegisterDetails() {
    // Get payment type and amount
    var paymentType = document.getElementById('payment-type').value;
    console.log("Selected Payment Type: ", paymentType); // For debugging
    var amount = parseFloat(document.getElementById('paying_amount').value) || 0;
    // Get tax, discount, and shipping
    var tax = parseFloat(document.getElementById('tax-input').value) || 0;
    var discount = parseFloat(document.getElementById('discount-input').value) || 0;
    var shipping = parseFloat(document.getElementById('shipping-input').value) || 0;

    // Reset all payment type amounts
    document.getElementById('cash-amount').innerText = 'RS 0.00';
    document.getElementById('credit-amount').innerText = 'RS 0.00';
    document.getElementById('debit-amount').innerText = 'RS 0.00';
    document.getElementById('online-amount').innerText = 'RS 0.00';

    if (paymentType === 'cash') {
        document.getElementById('cash-amount').innerText = 'RS ' + amount.toFixed(2);
    } else if (paymentType === 'credit_card') {
        document.getElementById('credit-amount').innerText = 'RS ' + amount.toFixed(2);
    } else if (paymentType === 'debit_card') {
        document.getElementById('debit-amount').innerText = 'RS ' + amount.toFixed(2);
    } else if (paymentType === 'online') {
        document.getElementById('online-amount').innerText = 'RS ' + amount.toFixed(2);
    }

    updateTotals();
}

function updateTotals() {
    // Retrieve individual payment amounts
    var cashAmount = parseFloat(document.getElementById('cash-amount').innerText.replace('RS ', '').replace(',', '')) || 0;
    var creditAmount = parseFloat(document.getElementById('credit-amount').innerText.replace('RS ', '').replace(',', '')) || 0;
    var debitAmount = parseFloat(document.getElementById('debit-amount').innerText.replace('RS ', '').replace(',', '')) || 0;
    var onlineAmount = parseFloat(document.getElementById('online-amount').innerText.replace('RS ', '').replace(',', '')) || 0;

    // Get tax, discount, and shipping
    var tax = parseFloat(document.getElementById('tax-input').value) || 0;
    var discount = parseFloat(document.getElementById('discount-input').value) || 0;
    var shipping = parseFloat(document.getElementById('shipping-input').value) || 0;

    // Calculate subtotal
    var subtotal = calculateSubtotal();

    // Calculate total sales
    var totalSales = subtotal + (subtotal * tax / 100) + shipping - discount;

    // Total payment includes all payment amounts
    var totalPayment = cashAmount + creditAmount + debitAmount + onlineAmount;

    // Update total sales and total payment
    document.getElementById('total-sales').innerText = 'RS ' + totalSales.toFixed(2);
    document.getElementById('total-payment').innerText = 'RS ' + totalPayment.toFixed(2);

    // Update grand total (assuming grand total is same as total sales)
    document.getElementById('grand-total').innerText = 'RS ' + totalSales.toFixed(2);
}

// print the register details
function printPage() {
    setTimeout(function () {
        var body = document.getElementById('body').innerHTML;
        var data = document.getElementById('data').innerHTML;
        document.getElementById('body').innerHTML = data;
        window.print();
        document.getElementById('body').innerHTML = body;
    }, 1000); // 1000 milliseconds = 1 second

}

// receipt printing
function printModal() {
    setTimeout(function () {
        var body = document.getElementById('body').innerHTML;
        var invoice = document.getElementById('invoice').innerHTML;
        document.getElementById('body').innerHTML = invoice;
        window.print();
        document.getElementById('body').innerHTML = body;
    }, 1000);
}


//  receipt
// Function to update total amount in other places

function formatCurrency(value) {
    return 'RS ' + parseFloat(value).toFixed(2);
}
function updateTotalAmountInOtherPlaces(totalAmountText) {
    // Update the value in the receipt section
    var receiptTotalAmount = document.getElementById('receipt-td-total-amount');
    if (receiptTotalAmount) {
        receiptTotalAmount.innerText = totalAmountText;
        console.log('Updated receipt total amount:', receiptTotalAmount.innerText);  // Log the updated value
    } else {
        console.log('Receipt total amount element not found!');
    }

    // Update the value in the table td
    var tableTotalAmount = document.getElementById('table-td-total-amount');
    if (tableTotalAmount) {
        tableTotalAmount.innerText = totalAmountText;
        console.log('Updated table total amount:', tableTotalAmount.innerText);  // Log the updated value
    } else {
        console.log('Table total amount element not found!');
    }
}

function updateReceipt() {
    // Get the selected payment type value
    var paymentTypeSelect = document.getElementById('payment-type');
    if (paymentTypeSelect) {
        var paymentTypeValue = paymentTypeSelect.value;
        console.log('Selected payment type:', paymentTypeValue);  // Log the selected payment type

        // Update the amount-paid element with payment type
        var amountPaidElement = document.getElementById('amount-paid');
        if (amountPaidElement) {
            amountPaidElement.textContent = paymentTypeValue;  // Only update with payment type
            console.log('Updated amount paid with payment type:', amountPaidElement.textContent);  // Log the updated value
        } else {
            console.log('Amount paid element not found!');
        }
    } else {
        console.log('Payment type select element not found!');
    }
}

function updateTax() {
    // Get the value from the tax-input element
    var taxInput = document.getElementById('tax-input');
    var taxValue = taxInput ? taxInput.value : '';

    // Check if the value is empty
    if (taxValue === '' || isNaN(taxValue)) {
        taxValue = 0; // Set default tax value to 0
    } else {
        taxValue = parseFloat(taxValue) / 100; // Convert percentage to decimal
    }

    // Get total amount from the total element
    var totalAmountElement = document.getElementById('total-amount'); // Ensure you have the correct ID
    var totalAmount = totalAmountElement ? parseFloat(totalAmountElement.textContent.replace('RS ', '')) : 0;

    // Calculate the tax amount
    var taxAmount = totalAmount * taxValue;

    // Deduct tax from total amount
    var finalAmount = totalAmount - taxAmount;

    // Format the values for display
    var formattedTaxAmount = 'RS ' + taxAmount.toFixed(2);
    var formattedFinalAmount = 'RS ' + finalAmount.toFixed(2);

    // Update the receipt-order-tax element
    var receiptOrderTaxElement = document.getElementById('receipt-order-tax');
    if (receiptOrderTaxElement) {
        receiptOrderTaxElement.textContent = formattedTaxAmount;
        console.log('Updated receipt order tax:', receiptOrderTaxElement.textContent); // Log the updated value
    } else {
        console.log('Receipt order tax element not found!');
    }

    // Update final amount display
    var finalAmountElement = document.getElementById('final-amount'); // Ensure you have the correct ID for final amount display
    if (finalAmountElement) {
        finalAmountElement.textContent = formattedFinalAmount;
        console.log('Updated final amount:', finalAmountElement.textContent); // Log the updated final amount
    } else {
        console.log('Final amount element not found!');
    }
}

function updateDiscount() {
    // Get the value from the discount-input element
    var discountInput = document.getElementById('discount-input');
    var discountValue = discountInput ? discountInput.value : '';

    // Check if the value is empty
    if (discountValue === '' || isNaN( e)) {
        discountValue = '00.00';
    } else {
        discountValue = parseFloat(discountValue).toFixed(2);
    }

    var formattedDiscountValue = 'RS ' + discountValue;

    // Update the receipt-discount element
    var receiptDiscountElement = document.getElementById('receipt-discount');
    if (receiptDiscountElement) {
        receiptDiscountElement.textContent = formattedDiscountValue;
        console.log('Updated receipt discount:', receiptDiscountElement.textContent);  // Log the updated value
    } else {
        console.log('Receipt discount element not found!');
    }
}

// Function to update the grand total
function updateGrandTotal() {
    // Get values from receipt elements
    var totalAmountElement = document.getElementById('receipt-td-total-amount');
    var taxElement = document.getElementById('receipt-order-tax');
    var discountElement = document.getElementById('receipt-discount');

    // Parse and calculate values
    var totalAmount = totalAmountElement ? parseFloat(totalAmountElement.textContent.replace('RS ', '').trim()) : 0;
    var taxAmount = taxElement ? parseFloat(taxElement.textContent.replace('RS ', '').trim()) : 0;
    var discountAmount = discountElement ? parseFloat(discountElement.textContent.replace('RS ', '').trim()) : 0;

    // Calculate grand total
    var grandTotal = totalAmount + taxAmount - discountAmount;

    // Format and update the grand total
    var grandTotalElement = document.getElementById('receipt-grand-total');
    if (grandTotalElement) {
        grandTotalElement.textContent = formatCurrency(grandTotal);
        console.log('Updated grand total:', grandTotalElement.textContent);  // Log the updated value
    } else {
        console.log('Receipt grand total element not found!');
    }
}

// Function to handle form submission and update total amounts
function handleFormSubmit(event) {
    event.preventDefault(); // Prevent default form submission

    // Get the value from the sub-total element
    var subTotalElement = document.getElementById('sub-total');
    if (subTotalElement) {
        // Ensure the value is correctly formatted
        var subTotalValue = parseFloat(subTotalElement.innerText.replace('RS ', '').trim());
        if (!isNaN(subTotalValue)) {
            var totalAmountText = 'RS ' + subTotalValue.toFixed(2);
            console.log('Total Amount Found:', totalAmountText);  // Log the fetched value

            // Update total amount in receipt and table
            updateTotalAmountInOtherPlaces(totalAmountText);

            // Update the receipt with paid amount
            updateReceipt();

            updateTax();
            updateDiscount();
            updateGrandTotal();

            // Fetch the value from the change return input field
            var changeReturnInput = document.getElementById('change-return');
            if (changeReturnInput) {
                var changeReturnValue = parseFloat(changeReturnInput.value).toFixed(2);
                var formattedChangeReturnValue = 'RS ' + changeReturnValue;

                // Update the change return display
                var changeReturnDisplay = document.getElementById('change-return-display');
                if (changeReturnDisplay) {
                    changeReturnDisplay.textContent = formattedChangeReturnValue;
                    console.log('Updated change return display:', changeReturnDisplay.textContent);  // Log the updated value
                } else {
                    console.log('Change return display element not found!');
                }
            } else {
                console.log('Change return input element not found!');
            }
        } else {
            console.log('Invalid sub-total value:', subTotalValue);
        }
    } else {
        console.log('Sub-total element not found!');
    }
}

// Add event listener to form submit
var orderForm = document.getElementById('paymentForm');
if (orderForm) {
    orderForm.addEventListener('submit', handleFormSubmit);
} else {
    console.log('Order form element not found!');
}

// pen icon for the edit profile
const penIcon = document.getElementById('penIcon');
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');
const userAvatar = document.querySelector('.custom-user-avatar');

if (penIcon) {
    penIcon.addEventListener('click', function () {
        if (fileInput) {
            fileInput.click();
        } else {
            console.error('fileInput element not found');
        }
    });
} else {
    // console.error('penIcon element not found');
}

if (fileInput) {
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (imagePreview) {
                    imagePreview.src = e.target.result;
                } else {
                    console.error('imagePreview element not found');
                }
                if (userAvatar) {
                    userAvatar.classList.add('d-none'); // Hide user initials
                } else {
                    console.error('userAvatar element not found');
                }
            };
            reader.readAsDataURL(file);
        } else {
            console.error('No file selected');
        }
    });
} else {
    // console.error('fileInput element not found');
}

// caculator
const screen = document.getElementById('calculator-screen');
const buttons = document.querySelectorAll('.btn, .btn-coloring, .large-btn');
let screenValue = '';

// Function to calculate and display the result
const calculateResult = () => {
    try {
        // Evaluate the expression and display the result
        screen.value = eval(screenValue) || '';
        screenValue = ''; // Reset screenValue after calculation
    } catch (error) {
        // Display an error message if the expression is invalid
        screen.value = 'Error';
        setTimeout(() => {
            screen.value = ''; // Clear the error after 1 second
        }, 1000);
        screenValue = ''; // Reset screenValue on error
    }
};

// Add event listeners to each button
buttons.forEach(button => {
    button.addEventListener('click', (e) => {
        let buttonValue = e.target.value;

        if (buttonValue === '=') {
            calculateResult();
        } else if (buttonValue === 'C') {
            // Remove the last character from the screenValue
            screenValue = screenValue.slice(0, -1);
            screen.value = screenValue;
        } else if (buttonValue === 'AC') {
            // Clear the entire screenValue
            screenValue = '';
            screen.value = screenValue;
        } else if (screenValue === 'Error' && buttonValue !== 'C' && buttonValue !== 'AC') {
            // If there's an error, reset the screen for a new calculation
            screenValue = buttonValue;
            screen.value = screenValue;
        } else {
            // Append the clicked button value to the screen
            screenValue += buttonValue;
            screen.value = screenValue;
        }
    });
});



// Chart JS
// var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });

// var ctx = document.getElementById('mypieChart').getContext('2d');
// var mypieChart = new Chart(ctx, {
//     type: 'pie',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });

















