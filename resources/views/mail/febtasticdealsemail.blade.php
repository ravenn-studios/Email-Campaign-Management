<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Febtastic Deals</title>
</head>

<body>
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Open Sans', Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Have you heard? It's Febtastic Sale! And our celebration is in full swing. P.S. No lines at our checkout, so what are you waiting for? Shop now!
</div>
    
<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['headers'] as $header)
	    <tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $header['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $header['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
	    </tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['subheaders'] as $subheader)
	    <tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $subheader['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $subheader['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
	    </tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['featured-products'] as $idx => $featured_product)
		<tr>
			@foreach($featured_product as $product)
		        <td style="text-align: center;">
					<a style="width: 600px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
						border="0"target="_BLANK"
						href="{{ route('test.click', ['url' => $product['url'], 'cuid' => $customer->id]) }}">
						<img src="{{ $product['image'] }}" width="600" border="0" style="display: block; width: 600px;">
					</a>
				</td>
			@endforeach
		</tr>
    @endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['middleheaders'] as $idx => $middle_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $middle_header['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $middle_header['image'] }}" width="500" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; border-spacing: 0px;">
	@foreach($items['banners'] as $idx => $banner)
	<tr>
        <td style="text-align: center;">
			<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
				border="0"target="_BLANK"
				href="{{ route('test.click', ['url' => $banner['url'], 'cuid' => $customer->id]) }}">
				<img src="{{ $banner['image'] }}" width="500" border="0" style="display: block; width: 1200px;">
			</a>
		</td>
	</tr>
	@endforeach
</table>


<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; border-spacing: 0px;">
	@foreach($items['best-selling-products'] as $idx => $best_selling_product)
		<tr>
			@foreach($best_selling_product as $product)
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $product['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $product['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
	   		@endforeach
		</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; border-spacing: 0px;">
	@foreach($items['deals-you-cant-miss'] as $idx => $best_selling_product)
		<tr>
			@foreach($best_selling_product as $product)
	        <td style="text-align: center;">
				<a style="width: 400px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $product['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $product['image'] }}" width="400" border="0" style="display: block; width: 400px;">
				</a>
			</td>
	   		@endforeach
		</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['finalheaders'] as $idx => $final_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $final_header['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $final_header['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>


<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['footers'] as $idx => $final_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.click', ['url' => $final_header['url'], 'cuid' => $customer->id]) }}">
					<img src="{{ $final_header['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>
{{-- <table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
    <tr>
        <td style="text-align: center;">
        	<img src="https://ultimatehosting.blackedgedigital.com/images/19e145bdd90ed119c0cb4a3ab814baa8&Footer-1&1669904298.jpg" width="1200" border="0" style="display: block; width: 1200px;">
		</td>
    </tr>
</table>
<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200"
	style="table-layout: fixed; width: 1200px; height: 76px; margin: 0 auto; background-color: #CEC3AD; background-image: url('https://ultimatehosting.blackedgedigital.com/images/36be68b1b604e1030f47323f9e007f1d&image_2022_12_07T23_04_04_358Z&1670454346.png'); background-size: cover;">
    <tr>
        <td style="text-align: center; width: 370px;"></td>
        <td style="text-align: center; width: 60px;">
			<a style="width: 40px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 12px;" 
				border="0"target="_BLANK"
				href="httroute('test.click', ['url' => ps://instagram.com/frankiesautoelectrics">
				<img src="https://ultimatehosting.blackedgedigital.com/images/476711817130659b14823b586c39f5b9&instagram&1669872268.png" width="40" border="0" style="display: block; width: 40px; height: 40px;">
			</a>
		</td>
        <td style="text-align: center; width: 40px;"></td>
        <td style="text-align: center; width: 60px;">
			<a style="width: 40px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 12px;" 
				border="0"target="_BLANK"
				href="httroute('test.click', ['url' => ps://www.facebook.com/www.frankiesautoelectrics.com.au/">
				<img src="https://ultimatehosting.blackedgedigital.com/images/355391592e89752ccdc452df4b853104&facebook&1669872201.png" width="40" border="0" style="display: block; width: 40px; height: 40px;">
			</a>
		</td>
        <td style="text-align: center; width: 40px;"></td>
        <td style="text-align: center; width: 60px;">
			<a style="width: 40px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 12px;" 
				border="0"target="_BLANK"
				href="httroute('test.click', ['url' => ps://www.youtube.com/@frankiesautoelectricscusto6214">
				<img src="https://ultimatehosting.blackedgedigital.com/images/27bbfd500023146e0053f4af840489b1&youtube&1669872299.png" width="40" border="0" style="display: block; width: 40px; height: 40px;">
			</a>
		</td>
        <td style="text-align: center; width: 370px;"></td>
    </tr>
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; background-color: #CEC3AD;">
    <tr>
        <td style="text-align: center;">
			<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
				border="0"target="_BLANK"
				href="httroute('test.click', ['url' => ps://frankiesautoelectrics.com.au">
				<img src="https://ultimatehosting.blackedgedigital.com/images/ab02570363faaf22298d381d4245174d&Footer-ADWEB&1669904189.jpg" width="1200" border="0" style="display: block; width: 1200px;">
			</a>
		</td>
    </tr>
</table>
 --}}
<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; background-color: #1D1D1D;">
	<tr style="background-color: #1D1D1D !important;">
		<td style="background-color: #1D1D1D;" align="center" style="margin-bottom: 24px; font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd; background-color: #1D1D1D; text-decoration: none !important; color: #fff">
			<p class="mobfont" style="font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>You're receiving this message because you've signed up for Frankies Auto Electrics with {{ $customer->email }}.</small></p>
			<p class="mobfont" style="font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>If you no longer wish to receive from our newsletter, please <a href="https://ultimatecampaignmanager.blackedgedigital.com/unsubscribe?customer={{ $customer->id }}" style="text-decoration: none !important; color: #fff; background-color: #1D1D1D !important;">unsubscribe here</a>.</small></p>
			{{-- <p style="background-color: #1D1D1D !important; height: 24px; background-color: #1D1D1D !important;"></p> --}}
		</td>
	</tr>
	<tr><td style="height: 8px; background-color: #1D1D1D;"></td></tr>
</table>
<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">Having trouble seeing this email on your iPhone/iPad? Turn your theme into light mode!</p>
<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">We reserve the right to change our product's prices at any time without further notice.</p>

</body>
</html>