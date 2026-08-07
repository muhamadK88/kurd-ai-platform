{{-- KURD AI — "Aurora Glass v3 · Static Tech" redesign layer.
     Loaded last in <head> so it sits on top of Tailwind + each page's
     inline styles. Purely presentational: no tools, categories, data or
     page logic depend on it.
     v3: blobs/goo/grain nuked. Solid canvas + static 44px tech grid on
     <html> (zero repaints). backdrop-filter only on .glass-card + ka-nav.
     FLIP pills, tilt/glare and the JS-managed GPU/will-change pipeline
     stay for the foreground.
     kurdai-nav.{css,js} wire the ka-* navigation component
     (resources/views/partials/nav.blade.php) — safe on pages that don't
     use it yet. --}}
<link rel="stylesheet" href="/css/kurdai-design.css?v=3">
<link rel="stylesheet" href="/css/kurdai-nav.css?v=3">
<script src="/js/kurdai-ui.js?v=3" defer></script>
<script src="/js/kurdai-nav.js?v=3" defer></script>
