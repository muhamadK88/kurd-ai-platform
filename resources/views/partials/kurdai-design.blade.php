{{-- KURD AI — "Aurora Glass v3 · Static Tech" redesign layer.
     Loaded last in <head> so it sits on top of Tailwind + each page's
     inline styles. Purely presentational: no tools, categories, data or
     page logic depend on it.
     v4 adds the "Cosmos" whole-site universe: Three.js particle
     constellation + aurora orbs + cursor glow + sparkles
     (public/css/kai-cosmos.css + public/js/kai-cosmos.js). Every layer
     falls back gracefully (reduced-motion / touch / low-end / no-WebGL).
     kurdai-nav.{css,js} wire the ka-* navigation component
     (resources/views/partials/nav.blade.php) — safe on pages that don't
     use it yet. --}}
<link rel="stylesheet" href="/css/kurdai-design.css?v=5">
<link rel="stylesheet" href="/css/kurdai-nav.css?v=4">
<link rel="stylesheet" href="/css/kai-cosmos.css?v=4">
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
<script src="/js/kurdai-ui.js?v=6" defer></script>
<script src="/js/kurdai-nav.js?v=4" defer></script>
<script src="/js/kai-cosmos.js?v=4" defer></script>
