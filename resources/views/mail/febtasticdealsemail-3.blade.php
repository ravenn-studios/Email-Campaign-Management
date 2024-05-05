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
					href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
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
					href="{{ route('test.track_click', ['url' => $subheader['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
					<img src="{{ $subheader['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
	    </tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	<tr>
        <td style="width: 55.5%; text-align: center;">
			<a style="width: 100%; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
				border="0"target="_BLANK"
				href="{{ route('test.track_click', ['url' => $items['featured-products-1'][0][0]['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
				<img src="{{ $items['featured-products-1'][0][0]['image'] }}" border="0" style="display: block; width: 100%;">
			</a>
		</td>
        <td style="width: 40.5%; text-align: center;">
			<a style="width: 100%; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
				border="0"target="_BLANK"
				href="{{ route('test.track_click', ['url' => $items['featured-products-1'][0][1]['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
				<img src="{{ $items['featured-products-1'][0][1]['image'] }}" border="0" style="display: block; width: 100%;">
			</a>
		</td>
	</tr>
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['headers-2'] as $idx => $middle_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.track_click', ['url' => $middle_header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
					<img src="{{ $middle_header['image'] }}" width="500" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['featured-products-2'] as $idx => $featured_product)
		<tr>
			@foreach($featured_product as $product)
		        <td style="text-align: center;">
					<a style="width: 300px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
						border="0"target="_BLANK"
						href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
						<img src="{{ $product['image'] }}" width="300" height="300" border="0" style="display: block; width: 300px;">
					</a>
				</td>
			@endforeach
		</tr>
    @endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; border-spacing: 0px;">
	@foreach($items['banners'] as $idx => $banner)
	<tr>
        <td style="text-align: center;">
			<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
				border="0"target="_BLANK"
				href="{{ route('test.track_click', ['url' => $banner['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
				<img src="{{ $banner['image'] }}" width="500" border="0" style="display: block; width: 1200px;">
			</a>
		</td>
	</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['featured-products-3'] as $idx => $featured_product)
		<tr>
			@foreach($featured_product as $product)
		        <td style="text-align: center;">
					<a style="width: 600px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
						border="0"target="_BLANK"
						href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
						<img src="{{ $product['image'] }}" width="600" border="0" style="display: block; width: 600px;">
					</a>
				</td>
			@endforeach
		</tr>
    @endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['headers-3'] as $idx => $middle_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.track_click', ['url' => $middle_header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
					<img src="{{ $middle_header['image'] }}" width="500" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>


<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto;">
	@foreach($items['finalheaders'] as $idx => $final_header)
		<tr>
	        <td style="text-align: center;">
				<a style="width: 1200px; vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
					border="0"target="_BLANK"
					href="{{ route('test.track_click', ['url' => $final_header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
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
					href="{{ route('test.track_click', ['url' => $final_header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}">
					<img src="{{ $final_header['image'] }}" width="1200" border="0" style="display: block; width: 1200px;">
				</a>
			</td>
		</tr>
	@endforeach
</table>

<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="1200" style="table-layout: fixed; width: 1200px; margin: 0 auto; background-color: #1D1D1D;">
	<tr style="background-color: #1D1D1D !important;">
		<td style="background-color: #1D1D1D;" align="center" style="margin-bottom: 24px; font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd; background-color: #1D1D1D; text-decoration: none !important; color: #fff">
			<p class="mobfont" style="font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>You're receiving this message because you've signed up for Frankies Auto Electrics with {{ $customer->email }}.</small></p>
			<p class="mobfont" style="font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>If you no longer wish to receive from our newsletter, please <a href="{{ route('test.track_unsubscribe', ['url' => $final_header['url'], 'cuid' => $customer->id, 'cid' => 3]) }}" style="text-decoration: none !important; color: #fff; background-color: #1D1D1D !important;">unsubscribe here</a>.</small></p>
			{{-- <p style="background-color: #1D1D1D !important; height: 24px; background-color: #1D1D1D !important;"></p> --}}
		</td>
	</tr>
	<tr><td style="height: 8px; background-color: #1D1D1D;"></td></tr>
</table>
<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">Having trouble seeing this email on your iPhone/iPad? Turn your theme into light mode!</p>
<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">We reserve the right to change our product's prices at any time without further notice.</p>

<img src="{{ route('test.tracking_pixel', ['cuid' => $customer->id, 'cid' => 3]) }}" width="1" height="1" alt="" style="display:none;">
</body>
</html>