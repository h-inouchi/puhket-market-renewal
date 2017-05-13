<?php

/* /private/var/www/html/puhket-market-renewal/src/Template/Layout/default.twig */
class __TwigTemplate_dddb91a9a3eee2de0f11b67495f32cbfdb3fbdeefd86073d443d79c7038e3802 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d3e3b64d3c51c67887c7c3cd6e89f9eb8af35ce5c1838d5ab311cddecb61c382 = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_d3e3b64d3c51c67887c7c3cd6e89f9eb8af35ce5c1838d5ab311cddecb61c382->enter($__internal_d3e3b64d3c51c67887c7c3cd6e89f9eb8af35ce5c1838d5ab311cddecb61c382_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "/private/var/www/html/puhket-market-renewal/src/Template/Layout/default.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:fb=\"http://www.facebook.com/2008/fbml\" xml:lang=\"ja\" lang=\"ja\">
<head>
  ";
        // line 4
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("http-equiv" => "X-UA-Compatible", "content" => "IE=edge")), "method");
        echo "
  ";
        // line 5
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("http-equiv" => "content-type", "content" => "text/html; charset=UTF-8")), "method");
        echo "
  ";
        // line 6
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "charset", array(), "method");
        echo "
  ";
        // line 7
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("name" => "viewport", "content" => "width=device-width, initial-scale=1.0")), "method");
        echo "
  <title>
";
        // line 9
        if ((twig_length_filter($this->env, (isset($context["title_for_layout"]) ? $context["title_for_layout"] : null)) == 0)) {
            // line 10
            echo "    ";
            echo $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "title"), "method");
            echo "
";
        } else {
            // line 12
            echo "    ";
            echo twig_escape_filter($this->env, (isset($context["title_for_layout"]) ? $context["title_for_layout"] : null), "html", null, true);
            echo "
";
        }
        // line 14
        echo "  </title>
  ";
        // line 15
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("name" => "description", "content" => "プーケットマーケットはオスカープロモーションで活躍中のお笑いトリオです。お笑いの養成所同期だが年齢場はバラバラのひだか、ほんだ、いのうちが所属し、それぞれTV、映画、CM、音楽、雑誌、インターネット、ファッションショー、イベントなど様々なエンターテイメント分野で活動することを目標に頑張っています。")), "method");
        echo "
  ";
        // line 16
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:title", "content" => $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "title"), "method"))), "method");
        echo "
  ";
        // line 17
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:type", "content" => "website")), "method");
        echo "
  ";
        // line 18
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:site_name", "content" => "プーケットマーケット")), "method");
        echo "
  ";
        // line 19
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:description", "content" => "プーケットマーケットはオスカープロモーションで活躍中のお笑いトリオです。お笑いの養成所同期だが年齢場はバラバラのひだか、ほんだ、いのうちが所属し、それぞれTV、映画、CM、音楽、雑誌、インターネット、ファッションショー、イベントなど様々なエンターテイメント分野で活動することを目標に頑張っています。")), "method");
        echo "
  ";
        // line 20
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:url", "content" => "http://www.puhket-market.com/")), "method");
        echo "
  ";
        // line 21
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => array("property" => "og:image", "content" => (isset($context["ogImageUrl"]) ? $context["ogImageUrl"] : null))), "method");
        echo "

  ";
        // line 23
        if (((isset($context["controllerName"]) ? $context["controllerName"] : null) == "Top")) {
            // line 24
            echo "    <script type=\"text/javascript\" charset=\"UTF-8\" src=\"/assets/js/libs.min.js?_=140612\"></script>
    ";
            // line 25
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "/assets/css/app.css?_=140612", 1 => array("media" => "all")), "method");
            echo "
    ";
            // line 26
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "/assets/css/print.css?_=140612", 1 => array("media" => "print")), "method");
            echo "
    ";
            // line 27
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "http://fonts.googleapis.com/css?family=Marmelad"), "method");
            echo "
  ";
        } else {
            // line 29
            echo "    ";
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "cake.generic"), "method");
            echo "
    ";
            // line 30
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "bootstrap"), "method");
            echo "
    ";
            // line 31
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"), "method");
            echo "
    ";
            // line 32
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "main"), "method");
            echo "
    ";
            // line 33
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "css", array(0 => "/assets/css/app-slider.css"), "method");
            echo "
    ";
            // line 34
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "script", array(0 => "vendor/jquery-1.11.2.min"), "method");
            echo "
    ";
            // line 35
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "script", array(0 => "vendor/modernizr-2.8.3-respond-1.4.2.min"), "method");
            echo "
    ";
            // line 36
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "script", array(0 => "vendor/bootstrap.min"), "method");
            echo "
  ";
        }
        // line 38
        echo "
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-76970893-1', 'auto');
    ga('require', 'GTM-PCGM3F3');
    ga('send', 'pageview');
  </script>

  ";
        // line 50
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "meta", array(0 => "icon"), "method");
        echo "
  ";
        // line 51
        echo $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "meta"), "method");
        echo "
  ";
        // line 52
        echo $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "css"), "method");
        echo "
  ";
        // line 53
        echo $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "script"), "method");
        echo "
</head>
<body>

  ";
        // line 57
        echo $this->getAttribute((isset($context["Flash"]) ? $context["Flash"] : null), "render", array(), "method");
        echo "
  <div class=\"jumbotron special\"></div>

  <div class=\"container clearfix\">
    ";
        // line 61
        echo $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "fetch", array(0 => "content"), "method");
        echo "

";
        // line 63
        if (((isset($context["controllerName"]) ? $context["controllerName"] : null) == "Top")) {
        } else {
            // line 65
            echo "    ";
            $this->loadTemplate("../Modules/header.twig", "/private/var/www/html/puhket-market-renewal/src/Template/Layout/default.twig", 65)->display($context);
            // line 66
            echo "    ";
            echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "script", array(0 => "/assets/js/swiper.min.js"), "method");
            echo "
    <script>
    var swiper = new Swiper('.swiper-container', {initialSlide: 4, freeMode: true, slidesPerView: \"auto\",
      autoplay: 8000, centeredSlides: true,
    });
    </script>
";
        }
        // line 73
        echo "  </div>

  <script>
  \$(function() {
    setTimeout(function() {
      \$('#flashMessage').fadeOut(\"slow\");
    }, 2000);
  });
  </script>

</body>
</html>
";
        
        $__internal_d3e3b64d3c51c67887c7c3cd6e89f9eb8af35ce5c1838d5ab311cddecb61c382->leave($__internal_d3e3b64d3c51c67887c7c3cd6e89f9eb8af35ce5c1838d5ab311cddecb61c382_prof);

    }

    public function getTemplateName()
    {
        return "/private/var/www/html/puhket-market-renewal/src/Template/Layout/default.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  204 => 73,  193 => 66,  190 => 65,  187 => 63,  182 => 61,  175 => 57,  168 => 53,  164 => 52,  160 => 51,  156 => 50,  142 => 38,  137 => 36,  133 => 35,  129 => 34,  125 => 33,  121 => 32,  117 => 31,  113 => 30,  108 => 29,  103 => 27,  99 => 26,  95 => 25,  92 => 24,  90 => 23,  85 => 21,  81 => 20,  77 => 19,  73 => 18,  69 => 17,  65 => 16,  61 => 15,  58 => 14,  52 => 12,  46 => 10,  44 => 9,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:fb=\"http://www.facebook.com/2008/fbml\" xml:lang=\"ja\" lang=\"ja\">
<head>
  {{ Html.meta({'http-equiv': \"X-UA-Compatible\", 'content': \"IE=edge\"})|raw }}
  {{ Html.meta({'http-equiv': \"content-type\", 'content': \"text/html; charset=UTF-8\"})|raw }}
  {{ Html.charset()|raw }}
  {{ Html.meta({'name': \"viewport\", 'content': \"width=device-width, initial-scale=1.0\"})|raw }}
  <title>
{% if title_for_layout|length == 0 %}
    {{ _view.fetch('title')|raw }}
{% else %}
    {{ title_for_layout }}
{% endif %}
  </title>
  {{ Html.meta({'name': \"description\", 'content': \"プーケットマーケットはオスカープロモーションで活躍中のお笑いトリオです。お笑いの養成所同期だが年齢場はバラバラのひだか、ほんだ、いのうちが所属し、それぞれTV、映画、CM、音楽、雑誌、インターネット、ファッションショー、イベントなど様々なエンターテイメント分野で活動することを目標に頑張っています。\"})|raw }}
  {{ Html.meta({'property': \"og:title\", 'content': _view.fetch('title') })|raw }}
  {{ Html.meta({'property': \"og:type\", 'content': \"website\" })|raw }}
  {{ Html.meta({'property': \"og:site_name\", 'content': \"プーケットマーケット\" })|raw }}
  {{ Html.meta({'property': \"og:description\", 'content': \"プーケットマーケットはオスカープロモーションで活躍中のお笑いトリオです。お笑いの養成所同期だが年齢場はバラバラのひだか、ほんだ、いのうちが所属し、それぞれTV、映画、CM、音楽、雑誌、インターネット、ファッションショー、イベントなど様々なエンターテイメント分野で活動することを目標に頑張っています。\" })|raw }}
  {{ Html.meta({'property': \"og:url\", 'content': \"http://www.puhket-market.com/\" })|raw }}
  {{ Html.meta({'property': \"og:image\", 'content': ogImageUrl })|raw }}

  {% if controllerName == \"Top\" %}
    <script type=\"text/javascript\" charset=\"UTF-8\" src=\"/assets/js/libs.min.js?_=140612\"></script>
    {{ Html.css(\"/assets/css/app.css?_=140612\", {'media': \"all\"})|raw }}
    {{ Html.css(\"/assets/css/print.css?_=140612\", {'media': \"print\"})|raw }}
    {{ Html.css(\"http://fonts.googleapis.com/css?family=Marmelad\")|raw }}
  {% else %}
    {{ Html.css('cake.generic')|raw }}
    {{ Html.css('bootstrap')|raw }}
    {{ Html.css('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')|raw }}
    {{ Html.css('main')|raw }}
    {{ Html.css('/assets/css/app-slider.css')|raw }}
    {{ Html.script('vendor/jquery-1.11.2.min')|raw }}
    {{ Html.script('vendor/modernizr-2.8.3-respond-1.4.2.min')|raw }}
    {{ Html.script('vendor/bootstrap.min')|raw }}
  {% endif %}

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-76970893-1', 'auto');
    ga('require', 'GTM-PCGM3F3');
    ga('send', 'pageview');
  </script>

  {{ Html.meta('icon')|raw }}
  {{ _view.fetch('meta')|raw }}
  {{ _view.fetch('css')|raw }}
  {{ _view.fetch('script')|raw }}
</head>
<body>

  {{ Flash.render()|raw }}
  <div class=\"jumbotron special\"></div>

  <div class=\"container clearfix\">
    {{ _view.fetch('content')|raw }}

{% if controllerName == \"Top\" %}
{% else %}
    {% include '../Modules/header.twig' %}
    {{ Html.script('/assets/js/swiper.min.js')|raw }}
    <script>
    var swiper = new Swiper('.swiper-container', {initialSlide: 4, freeMode: true, slidesPerView: \"auto\",
      autoplay: 8000, centeredSlides: true,
    });
    </script>
{% endif %}
  </div>

  <script>
  \$(function() {
    setTimeout(function() {
      \$('#flashMessage').fadeOut(\"slow\");
    }, 2000);
  });
  </script>

</body>
</html>
", "/private/var/www/html/puhket-market-renewal/src/Template/Layout/default.twig", "");
    }
}
