@if (app('site')->coordinate)
  <iframe width="100%" height="300" frameborder="0" allowfullscreen src="https://maps.google.com/maps?q={!! str_replace(" ", "", app('site')->coordinate) !!}&hl={{ app('site')->language }}&z=17&output=embed">
  </iframe>
@endif