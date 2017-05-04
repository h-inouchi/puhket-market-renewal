<?php

/* /private/var/www/html/puhket-market-renewal/src/Template/Top/index.twig */
class __TwigTemplate_3754a3e29a9f1ba09ed5e7d8e07268486577a13a1bb0bc0e1edf8a77656bb379 extends Twig_Template
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
        $__internal_b809b05c07190568e9accdd11a647d88211b2ba4b17323900d0b84964631721e = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_b809b05c07190568e9accdd11a647d88211b2ba4b17323900d0b84964631721e->enter($__internal_b809b05c07190568e9accdd11a647d88211b2ba4b17323900d0b84964631721e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "/private/var/www/html/puhket-market-renewal/src/Template/Top/index.twig"));

        // line 1
        $this->getAttribute((isset($context["_view"]) ? $context["_view"] : null), "assign", array(0 => "title", 1 => "プーケットマーケット"), "method");
        
        $__internal_b809b05c07190568e9accdd11a647d88211b2ba4b17323900d0b84964631721e->leave($__internal_b809b05c07190568e9accdd11a647d88211b2ba4b17323900d0b84964631721e_prof);

    }

    public function getTemplateName()
    {
        return "/private/var/www/html/puhket-market-renewal/src/Template/Top/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% do _view.assign('title', 'プーケットマーケット') %}", "/private/var/www/html/puhket-market-renewal/src/Template/Top/index.twig", "");
    }
}
