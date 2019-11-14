<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/{{config('asgard.idocs.config.oglocale')}}/sdk.js#xfbml=1&version=v4.0&appId={!!Setting::get('idocs::id-facebook') !!}&autoLogAppEvents=1"></script>

<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/{{config('asgard.idocs.config.oglocale')}}/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function checkRecaptcha(){
      if(grecaptcha && grecaptcha.getResponse().length !== 0)
        $('#sendBtn').removeAttr('disabled');
      else
        $('#sendBtn').attr('disabled','disabled');
    }

    function disableButton(){
      $('#sendBtn').attr('disabled','disabled');
    }
</script>
{{--
<script type="application/ld+json">
    {
        "publisher":{
            "name":"El Tiempo",
            "@type":"Organization",
            "logo":{
                "@type":"ImageObject",
                "url":"https:\/\/www.eltiempo.com\/bundles\/eltiempocms\/images\/el-tiempo\/logo-el-tiempo-azul.jpg",
                "width":600,
                "height":60
            }
        },
        "hasPart":{"@type":"WebPageElement","isAccessibleForFree":"true","cssSelector":".article"}}

</script>--}}
