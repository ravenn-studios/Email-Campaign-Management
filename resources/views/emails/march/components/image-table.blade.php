@if(isset($items[$key]))
<table class="module desktop-view" table-view="desktop" role="module" data-type="code" border="0" cellpadding="0" cellspacing="0" width="100%">
    @foreach($items[$key] as $idx => $row)
        <tr>
            @foreach(is_array($row) ? $row : [$row] as $k => $item)
                {{ json_encode($k) . PHP_EOL }}
                {{ json_encode($item) . PHP_EOL }}
                {{-- <td style="text-align: center;">
                    <a style="vertical-align: middle; text-decoration:none; border-spacing:0; mso-line-height-rule: exactly; mso-margin-bottom-alt:0; mso-margin-top-alt:0; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:0px; display: flex; justify-content: center; margin: 0 auto;" 
                       border="0" target="_BLANK"
                       href="{{ route('test.track_click', ['url' => $item['url'], 'cuid' => $customer->id, 'cid' => $campaign->campaign_id]) }}">
                        <img src="{{ $item['image'] }}" border="0" style="display: block; width: 100%;">
                    </a>
                </td> --}}
            @endforeach
        </tr>
    @endforeach
</table>
@endif