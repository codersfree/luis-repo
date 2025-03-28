<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }} | Coders Free</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Font awesome -->
<link rel="stylesheet" href="{{asset('assets/fontawesome-free-6.6.0-web/css/all.min.css')}}">

{{-- Sortable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"
integrity="sha512-5x7t0fTAVo9dpfbp3WtE2N6bfipUwk7siViWncdDoSz2KwOqVC1N9fDxEOzk0vTThOua/mglfF8NO7uVDLRC8Q=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<wireui:scripts />
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
