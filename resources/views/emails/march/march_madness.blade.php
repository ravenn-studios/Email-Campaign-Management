<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Febtastic Deals</title>
</head>
<body>
	<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Open Sans', Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
		Have you heard? It's March Madness Sale! And our celebration is in full swing. P.S. No lines at our checkout, so what are you waiting for? Shop now!
	</div>

	<img src="{{ route('test.tracking_pixel', ['cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}" width="1" height="1" alt="" style="display:none;">
	    
	<div style="margin:0px auto; max-width: 700px">
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['headers'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['subheaders-1'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['featured-products-1'] as $idx => $featured_product)
				<tr>
					@foreach($featured_product as $product)
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $product['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
					@endforeach
				</tr>
		    @endforeach
		</table>
		@if(isset($items['featured-products-1-1']))
			<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
				<tr>
			        <td style="text-align: center;" rowspan="2">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $items['featured-products-1-1'][0][0]['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $items['featured-products-1-1'][0][0]['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $items['featured-products-1-1'][1][0]['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $items['featured-products-1-1'][1][0]['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
				</tr>
				<tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $items['featured-products-1-1'][1][1]['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $items['featured-products-1-1'][1][1]['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
				</tr>
			</table>
		@endif
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['subheaders-2'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>		
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['featured-products-2'] as $idx => $featured_product)
				<tr>
					@foreach($featured_product as $product)
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $product['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
					@endforeach
				</tr>
		    @endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['subheaders-3'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['featured-products-3'] as $idx => $featured_product)
				<tr>
					@foreach($featured_product as $product)
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $product['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
					@endforeach
				</tr>
		    @endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['subheaders-4'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['featured-products-4'] as $idx => $featured_product)
				<tr>
					@foreach($featured_product as $product)
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $product['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
					@endforeach
				</tr>
		    @endforeach
		</table>
		@if(isset($items['subheaders-5']))
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['subheaders-5'] as $header)
			    <tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
			    </tr>
			@endforeach
		</table>
		@endif
		@if(isset($items['featured-products-5']))
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['featured-products-5'] as $idx => $featured_product)
				<tr>
					@foreach($featured_product as $product)
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $product['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $product['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
					@endforeach
				</tr>
		    @endforeach
		</table>
		@endif

		@if(isset($items['subheaders-6']))
			<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
				@foreach($items['subheaders-'] as $header)
				    <tr>
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
				    </tr>
				@endforeach
			</table>
		@endif

		@if(isset($items['featured-products-6']))
			<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
				@foreach($items['featured-products-6'] as $header)
				    <tr>
				        <td style="text-align: center;">
							<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
								border="0"target="_BLANK"
								href="{{ route('test.track_click', ['url' => $header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
								<img src="{{ $header['image'] }}" border="0" style="display: block; width: 100%;">
							</a>
						</td>
				    </tr>
				@endforeach
			</table>
		@endif

		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			@foreach($items['footers'] as $idx => $final_header)
				<tr>
			        <td style="text-align: center;">
						<a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
							border="0"target="_BLANK"
							href="{{ route('test.track_click', ['url' => $final_header['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
							<img src="{{ $final_header['image'] }}" border="0" style="display: block; width: 100%;">
						</a>
					</td>
				</tr>
			@endforeach
		</table>
		<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #1D1D1D;">
			<tr style="background-color: #1D1D1D !important;">
				<td style="background-color: #1D1D1D; text-align: center;" align="center" style="margin-bottom: 24px; font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd; background-color: #1D1D1D; text-decoration: none !important; color: #fff">
					<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>You're receiving this message because you've signed up for Frankies Auto Electrics with {{ $customer->email }}.</small></p>
					<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 0.7rem; color: #c7c6cd;"><small>If you no longer wish to receive from our newsletter, please <a href="{{ route('test.track_unsubscribe', ['url' => $items['footers'][0]['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}" style="text-decoration: none !important; color: #fff; background-color: #1D1D1D !important;">unsubscribe here</a>.</small></p>
				</td>
			</tr>
			<tr><td style="height: 8px; background-color: #1D1D1D;"></td></tr>
		</table>
		<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">Having trouble seeing this email on your iPhone/iPad? Turn your theme into light mode!</p>
		<p class="mobfont" style="text-align: center; font-family: 'Open Sans', sans-serif; margin:4px auto; font-size: 0.7em; color: #000;">We reserve the right to change our product's prices at any time without further notice.</p>
	</div>
</body>
</html>