<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Unsubscribe Page</title>
		<style>
			body {
				font-family: "Manrope", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
				background-color: #f4f4f4;
				margin: 0;
				padding: 0;
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100vh;
			}

			.unsubscribe-container {
				background: #fff;
				padding: 20px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				width: 400px;
				border-radius: 8px;
			}

			.header-logo {
				text-align: center;
				margin-bottom: 20px;
			}

			.header-logo img {
				max-width: 100%;
				height: auto;
			}

			.unsubscribe-header {
				text-align: center;
				margin-bottom: 20px;
			}

			.unsubscribe-header h2 {
				margin: 0;
			}

			.unsubscribe-content {
				margin-bottom: 20px;
			}

			.unsubscribe-content p {
				margin: 0 0 10px 0;
			}

			.unsubscribe-content label,
			.unsubscribe-content input {
				cursor: pointer;
			}

			.unsubscribe-content input[type="radio"],
			.unsubscribe-content input[type="checkbox"] {
				margin-right: 10px;
			}

			.indent {
				margin-left: 20px;
				display: block;
			}

			.unsubscribe-button {
				display: block;
				width: 100%;
				padding: 10px;
				border: none;
				background-color: #0055a5;
				color: white;
				text-align: center;
				border-radius: 5px;
				cursor: pointer;
				font-size: 16px;
			}

			.unsubscribe-button:hover {
				background-color: #003973;
			}

			.report-spam {
				text-align: center;
				margin-top: 20px;
			}

			.report-spam a {
				color: #0055a5;
				text-decoration: none;
				font-size: 14px;
			}

			.report-spam a:hover {
				text-decoration: underline;
			}
		</style>
	</head>
	<body>
		@if(!$customer->unsubscribe)
		<form method="POST" action={{ route('unsubscribe.submit') }}>
			@csrf
			<input type="hidden" name="url" value='https://frankiesautoelectrics.com.au/unsubscribe'>
			<input type="hidden" name="cuid" value={{ $customer->id }}>
			<input type="hidden" name="cid" value={{ $campaign_id }}>
			<div class="unsubscribe-container">
				<div class="header-logo">
					<img src="https://frankiesautoelectrics.com.au/wp-content/uploads/2022/04/cropped-FAE-NEW.png" alt="Header Logo">
				</div>
				<div class="unsubscribe-header">
					<h2>Unsubscribe</h2>
				</div>
				<div class="unsubscribe-content">
					<p>Your email address <strong>{{ $customer->email }}</strong>
					</p>
					<p>You will not receive any more emails from our campaigns.</p>
				</div>
				<button class="unsubscribe-button">Unsubscribe</button>
				<div class="report-spam">
					<a href="{{ route('test.track_spam_report', ['cuid' => $customer->id, 'cid' => $campaign_id]) }}">Report spam</a>
				</div>
			</div>
		</form>
		@else
			<div class="unsubscribe-container">
				<div class="header-logo">
					<img src="https://frankiesautoelectrics.com.au/wp-content/uploads/2022/04/cropped-FAE-NEW.png" alt="Header Logo">
				</div>
				<div class="unsubscribe-header">
					<h2>You are already unsubscribed!</h2>
				</div>
				<div class="unsubscribe-content">
					<p>Your email address <strong>{{ $customer->email }}</strong></p>
					<p>You will not receive any more emails from our campaigns.</p>
					<p>You may close this tab/window.</p>
				</div>
				<div class="report-spam">
					<a href="{{ route('test.track_spam_report', ['cuid' => $customer->id, 'cid' => $campaign_id]) }}">Report spam</a>
				</div>
			</div>
		@endif
	</body>
</html>