<script>
    window._token = '{{ csrf_token() }}';
    $('.select2').select2({
        'theme'      : 'default',
        'placeholder': '-'
        //    'minimumResultsForSearch': Infinity,
    });
</script>

<!-- DELETER -->
<script src="/js/deleter.js"></script>
<!-- CUSTOM JS -->
@yield('javascript')