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
        $__internal_ddc0741fe9f7a3366ee0665fa36a6b64b35b5d53cda5af8e4b5fd215519674f6 = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_ddc0741fe9f7a3366ee0665fa36a6b64b35b5d53cda5af8e4b5fd215519674f6->enter($__internal_ddc0741fe9f7a3366ee0665fa36a6b64b35b5d53cda5af8e4b5fd215519674f6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "/private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig"));

        // line 1
        echo "<div class=\"users form\">
";
        // line 2
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "create", array(0 => (isset($context["user"]) ? $context["user"] : null)), "method");
        echo "
    <fieldset>
        <legend><?= __('Add User') ?></legend>
    \t";
        // line 5
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "username"), "method");
        echo "
    \t";
        // line 6
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "password"), "method");
        echo "
    \t";
        // line 7
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "control", array(0 => "role", 1 => array("options" => array("admin" => "Admin", "author" => "Author"))), "method");
        echo "
   </fieldset>
";
        // line 9
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "button", array(0 => __("Submit")), "method");
        echo "
";
        // line 10
        echo $this->getAttribute((isset($context["Form"]) ? $context["Form"] : null), "end", array());
        echo "
</div>";
        
        $__internal_ddc0741fe9f7a3366ee0665fa36a6b64b35b5d53cda5af8e4b5fd215519674f6->leave($__internal_ddc0741fe9f7a3366ee0665fa36a6b64b35b5d53cda5af8e4b5fd215519674f6_prof);

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
        return array (  48 => 10,  44 => 9,  39 => 7,  35 => 6,  31 => 5,  25 => 2,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"users form\">
{{ Form.create(user)|raw }}
    <fieldset>
        <legend><?= __('Add User') ?></legend>
    \t{{ Form.control('username')|raw }}
    \t{{ Form.control('password')|raw }}
    \t{{ Form.control('role', {'options': {'admin': 'Admin', 'author': 'Author'}})|raw }}
   </fieldset>
{{ Form.button(__('Submit'))|raw }}
{{ Form.end|raw }}
</div>", "/private/var/www/html/puhket-market-renewal/src/Template/Users/add.twig", "");
    }
}
