<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={!! data_get($site_settings,'GA_CODE') !!}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{!! data_get($site_settings,'GA_CODE') !!}', {'anonymizeIp': true});
</script>
