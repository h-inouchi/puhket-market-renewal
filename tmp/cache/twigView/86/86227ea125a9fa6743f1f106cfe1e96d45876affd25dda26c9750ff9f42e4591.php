<?php

/* /private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig */
class __TwigTemplate_422bef791524c8c5b075d5b926d62b4754832a66ad19bbf1e87bc48e0dbc7cd2 extends Twig_Template
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
        $__internal_42e0244982ca9001057a6bc3a62724b12cd4d204965d12a3cd28408b003f44af = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_42e0244982ca9001057a6bc3a62724b12cd4d204965d12a3cd28408b003f44af->enter($__internal_42e0244982ca9001057a6bc3a62724b12cd4d204965d12a3cd28408b003f44af_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "/private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig"));

        // line 1
        echo "<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
        <li>";
        // line 4
        echo $this->getAttribute((isset($context["Html"]) ? $context["Html"] : null), "link", array(0 => __("List Users"), 1 => array("action" => "index")), "method");
        echo "</li>
    </ul>
</nav>
<div class=\"users form large-9 medium-8 columns content\">
";
        // line 8
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "create", array(0 => (isset($context["user"]) ? $context["user"] : null)), "method");
        echo "
    <fieldset>
        <legend><?= __('Add User') ?></legend>
    \t";
        // line 11
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "username"), "method");
        echo "
    \t";
        // line 12
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "password"), "method");
        echo "
    \t";
        // line 13
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "role", 1 => array("options" => array("admin" => "Admin", "author" => "Author"))), "method");
        echo "
      ";
        // line 14
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "unit_name"), "method");
        echo "
   </fieldset>
";
        // line 16
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "button", array(0 => __("Submit")), "method");
        echo "
";
        // line 17
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "end", array());
        echo "
</div>";
        
        $__internal_42e0244982ca9001057a6bc3a62724b12cd4d204965d12a3cd28408b003f44af->leave($__internal_42e0244982ca9001057a6bc3a62724b12cd4d204965d12a3cd28408b003f44af_prof);

    }

    public function getTemplateName()
    {
        return "/private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 17,  57 => 16,  52 => 14,  48 => 13,  44 => 12,  40 => 11,  34 => 8,  27 => 4,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<nav class=\"large-3 medium-4 columns\" id=\"actions-sidebar\">
    <ul class=\"side-nav\">
        <li class=\"heading\"><?= __('Actions') ?></li>
        <li>{{ Html.link(__('List Users'), {'action' : 'index'})|raw }}</li>
    </ul>
</nav>
<div class=\"users form large-9 medium-8 columns content\">
{{ Form.create(user)|raw }}
    <fieldset>
        <legend><?= __('Add User') ?></legend>
    \t{{ Form.control('username')|raw }}
    \t{{ Form.control('password')|raw }}
    \t{{ Form.control('role', {'options': {'admin': 'Admin', 'author': 'Author'}})|raw }}
      {{ Form.control('unit_name')|raw }}
   </fieldset>
{{ Form.button(__('Submit'))|raw }}
{{ Form.end|raw }}
</div>", "/private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig", "");
    }
}
