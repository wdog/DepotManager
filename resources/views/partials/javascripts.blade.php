<script>
    window._token = '{{ csrf_token() }}';
    $('.select2').select2({'theme': 'default'});
</script>

<!-- DELETER -->
<script src="/js/deleter.js"></script>
<!-- CUSTOM JS -->
@yield('javascript')