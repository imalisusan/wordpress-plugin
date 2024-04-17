<head>
	<link rel="stylesheet" type="text/css"
		href="http://127.0.0.1:5500/wp-content/plugins/imali-plugin/templates/style.css">
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
			<div>
				<input type="text" name="coupon" id="coupon" placeholder="Coupon code">
				<input type="submit" name="submit" value="Apply Coupon">
			</div>
		</div>
	</div>
	<div class="row">
		<form method="post" id="myForm">
			<div class="col-7 col">
				<h3 class="topborder"><span>Billing Details</span></h3>
				<label for="country">Country</label><br>
				<select id="countries"></select>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				<script>
					function toSentenceCase(str) {
						return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
					}
					$(document).ready(function () {
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
							response.forEach(function (country) {
								if (country.name && country.name.shortname) {
									const option = $('<option></option>').val(toSentenceCase(country.name.shortname)).text(toSentenceCase(country.name.shortname));
									select.append(option);
								}
							});
						});
					});
				</script>
				<div class="width50 padright">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" id="first_name" required>
				</div>
				<div class="width50">
					<label for="last_name">Last Name</label>
					<input type="text" name="last_name" id="last_name" required>
				</div>
				<br><br><br>

				<label for="company_name">company_name Name</label>
				<input type="text" name="company_name" id="company_name" required>
				<label for="address">Address</label>
				<input type="text" name="address" id="address" required>
				<label for="city">Town / City</label>
				<input type="text" name="city" id="city" required>
				<div class="width50 padright">
					<label for="email">Email Address</label>
					<input type="text" name="email" id="email" required>
				</div>
				<div class="width50">
					<label for="phone">Phone</label>
					<input type="text" name="phone" id="phone" required>
				</div>
				<input type="checkbox" value="2" name="checkbox">
				<p>Create an account?</p>
				<h3 class="topborder"><span>Shipping Address</span></h3>
				<input type="checkbox" value="3" name="checkbox">
				<p>Ship to a different address?</p>
				<label for="notes" class="notes">Order Notes</label>
				<textarea name="notes" id="notes"
					placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
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
						$(document).ready(function () {
							const settings = {
								async: true,
								crossDomain: true,
								url: 'http://127.0.0.1:8001/api/order-details',
								method: 'GET',
							};
							$(document).ready(function () {
								$.ajax(settings).done(function (response) {
									const ordersContainer = $('#orders');
									response.data.forEach(function (order) {
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
				<div>
					<h5>Cart Subtotal</h5>
				</div>
				<div>
					<h5 class="inline difwidth">Shipping and Handling</h5>
					<p class="inline alignright center">Free Shipping</p>
				</div>
				<div>
					<h5>Order Total</h5>
				</div>

				<div>
					<h3 class="topborder"><span>Payment Method</span></h3>
					<input type="radio" value="banktransfer" name="payment" checked>
					<p>Direct Bank Transfer</p>
					<p class="padleft">
						Make your payment directly into our bank account. Please use your Order ID as the payment
						reference. Your order won't be shipped until the funds have cleared in our account.
					</p>
				</div>

				<div><input type="radio" value="cheque" name="payment">
					<p>Credit Card</p>
				</div>
				<div>
					<input type="radio" value="paypal" name="payment">
					<p>Paypal</p>

				</div>
				<input type="button" name="submit" value="Place Order" class="redbutton" onclick="submitForm()">
			</div>
		</form>
	</div>
</div>

<script>
	function submitForm() {
		var form = document.getElementById('myForm');
		if (form) {
			let formData = new FormData(form);
			console.log(formData);

			let formDataObject = {};

			for (const [key, value] of formData.entries()) {
				formDataObject[key] = value;
			}

			console.log(formDataObject);

			fetch('http://127.0.0.1:8001/api/customer-details', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(Object.fromEntries(formData))
			})
				.then(response => response.json())
				.then(data => {
					console.log(data);
					window.alert('Please check your email');
				})
				.catch((error) => console.error('Error:', error));
		} else {
			console.error('Form not found');
		}
	}




</script>