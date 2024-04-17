<head>
<link rel="stylesheet" type="text/css" href="http://127.0.0.1:5500/wp-content/plugins/imali-plugin/templates/style.css">
</head>
<header>
	<h3>Imali Plugin Checkout</h3>
</header>
		<div class="white-space"></div>
		<div class="wrapper">
			<div class="row">
				<div class="col-12 col">
					<div class="info-bar">
						<p>
							<i class="fa fa-info"></i> 
							Have a coupon? <a href="#">Enter the coupon below</a>
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6 col coupon">
					<form method="get">
						<input type="text" name="coupon" id="coupon" placeholder="Coupon code">
						<input type="submit" name="submit" value="Apply Coupon">
					</form>
				</div>
			</div>
			<div class="row">
				<form method="post" action="http://127.0.0.1:5500/wp-content/plugins/imali-plugin/templates/custom-checkout.php">
					<div class="col-7 col">
						<h3 class="topborder"><span>Billing Details</span></h3>
                            <label for="country">Country</label><br>
                            <select id="countries"></select>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                            <script>
                                function toSentenceCase(str) {
                                    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
                                }
                            $(document).ready(function() {
                                const settings = {
                                    async: true,
                                    crossDomain: true,
                                    url: 'https://rest-countries10.p.rapidapi.com/countries',
                                    method: 'GET',
                                    headers: {
                                        'X-RapidAPI-Key': 'be720e34a1msha5bfab11947d986p19c52cjsn7d97525068d0',
                                        'X-RapidAPI-Host': 'rest-countries10.p.rapidapi.com'
                                    }
                                };

                                $.ajax(settings).done(function (response) {
                                    const select = $('#countries');
                                    response.forEach(function(country) {
                                        if (country.name && country.name.shortname) {
                                            const option = $('<option></option>').val(toSentenceCase(country.name.shortname)).text(toSentenceCase(country.name.shortname));
                                            select.append(option);
                                        }
                                    });
                                });
                            });
                            </script>
						<div class="width50 padright">
							<label for="fname">First Name</label>
							<input type="text" name="fname" id="fname" required>
						</div>
						<div class="width50">
							<label for="lname">Last Name</label>
							<input type="text" name="lname" id="lname" required>
						</div>
                        <br><br><br>

						<label for="company">Company Name</label>
						<input type="text" name="company" id="company" required>
						<label for="address">Address</label>
						<input type="text" name="address" id="address" required>
						<label for="city">Town / City</label>
						<input type="text" name="city" id="city" required>
						<div class="width50 padright">
							<label for="email">Email Address</label>
							<input type="text" name="email" id="email" required>
						</div>
						<div class="width50">
							<label for="tel">Phone</label>
							<input type="text" name="tel" id="tel" required>
						</div>
						<input type="checkbox" value="2" name="checkbox"><p>Create an account?</p>
						<h3 class="topborder"><span>Shipping Address</span></h3>
						<input type="checkbox" value="3" name="checkbox"><p>Ship to a different address?</p>
						<label for="notes" class="notes">Order Notes</label>
						<textarea name="notes" id="notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
					</div>
					<div class="col-5 col order">
						<h3 class="topborder"><span>Your Order</span></h3>
						<div class="row">
							<h4 class="inline">Product</h4>
							<h4 class="inline alignright">Total</h4>
						</div>
						<div>
				
						<p id="orders" class="prod-description inline">
							</p>
						<script>
						$(document).ready(function() {
						const settings = {
							async: true,
							crossDomain: true,
							url: 'http://127.0.0.1:8001/api/order-details',
							method: 'GET',
						};
						$(document).ready(function() {
							$.ajax(settings).done(function (response) {
							const ordersContainer = $('#orders');
							response.data.forEach(function(order) {
								if (order && order.customer_id) {
									const orderElement = $('<p></p>').text(`Item ID: ${order.id}, ${order.product} , Quantity: ${order.quantity}`);
									ordersContainer.append(orderElement);
								} else {
									console.log('Invalid order:', order);
								}
							});
							});
						});

				
					});
					</script>
						</div>
						<div><h5>Cart Subtotal</h5></div>
						<div>
							<h5 class="inline difwidth">Shipping and Handling</h5>
							<p class="inline alignright center">Free Shipping</p>
						</div>
						<div><h5>Order Total</h5></div>

						<div>
							<h3 class="topborder"><span>Payment Method</span></h3>
							<input type="radio" value="banktransfer" name="payment" checked><p>Direct Bank Transfer</p>
							<p class="padleft">
								Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.
							</p>
						</div>

						<div><input type="radio" value="cheque" name="payment"><p>Credit Card</p></div>
						<div>
							<input type="radio" value="paypal" name="payment"><p>Paypal</p>
							<fieldset class="paymenttypes">
								<legend><img src="data:image/png;base64,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" alt="PayPal Logo" class="paypal"></legend>
							</fieldset>
						</div>
						<input type="submit" name="submit" value="Place Order" class="redbutton">
					</div>
				</form>
			</div>
		</div>

		<script>
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(event.target);

    let data = {
        "first_name": formData.get('first_name'),
        "last_name": formData.get('last_name'),
        "company_name": formData.get('company_name'),
        "address": formData.get('address'),
        "city": formData.get('city'),
        "email": formData.get('email'),
        "phone": formData.get('phone')
    };

    fetch('http://127.0.0.1:8001/api/customer-details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
    .then(data => console.log(data))
    .catch((error) => console.error('Error:', error));
});
</script>
