<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* base.html */
class __TwigTemplate_85af1357def222e31f25fd8968bc23c58f0d683b3dca5f45781c24adbd8a1fdc extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'extras' => [$this, 'block_extras'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>MVC Framework - ";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    
    <!--Scripts, styles, etc. required in all the pages-->
    
    <!--Block for specific scripts, styles, etc.-->
    ";
        // line 12
        $this->displayBlock('extras', $context, $blocks);
        // line 14
        echo "</head>
<body>
    ";
        // line 16
        echo twig_escape_filter($this->env, ($context["uid"] ?? null), "html", null, true);
        echo "
    <nav>
        <a href=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["url_basis"] ?? null), "html", null, true);
        echo "signup\">Signup</a> | 
        <a href=\"";
        // line 19
        echo twig_escape_filter($this->env, ($context["url_basis"] ?? null), "html", null, true);
        echo "\">Home</a> | 
        <a href=\"";
        // line 20
        echo twig_escape_filter($this->env, ($context["url_basis"] ?? null), "html", null, true);
        echo "login\">Login</a>
    </nav>
    ";
        // line 22
        $this->displayBlock('body', $context, $blocks);
        // line 24
        echo "</body>
</html>";
    }

    // line 7
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 12
    public function block_extras($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 13
        echo "    ";
    }

    // line 22
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 23
        echo "    ";
    }

    public function getTemplateName()
    {
        return "base.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 23,  101 => 22,  97 => 13,  93 => 12,  87 => 7,  82 => 24,  80 => 22,  75 => 20,  71 => 19,  67 => 18,  62 => 16,  58 => 14,  56 => 12,  48 => 7,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "base.html", "E:\\laragon\\laragon\\www\\myownframeworklogin\\App\\Views\\base.html");
    }
}
