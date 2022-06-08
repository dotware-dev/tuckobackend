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

/* login/index.html */
class __TwigTemplate_f46d2b9cf74a52a73f9d0f6236d1814342277a501f25bf93032ccc54700cd02e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'extras' => [$this, 'block_extras'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html", "login/index.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Login
";
    }

    // line 4
    public function block_extras($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 6
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        echo "    <h1>Login</h1>
    ";
        // line 8
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "errors", [], "any", false, false, false, 8))) {
            // line 9
            echo "        <p>ERRORS</p>
        <ul>
            ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "errors", [], "any", false, false, false, 11));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 12
                echo "                <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 14
            echo "        </ul>
        
    ";
        }
        // line 17
        echo "    <form action=\"";
        echo twig_escape_filter($this->env, ($context["url_basis"] ?? null), "html", null, true);
        echo "login/create\" method=\"post\" id=\"formLogin\">
        <div>
            <label for=\"email\">email</label>
            <input type=\"email\" name=\"email\" id=\"email\" autofocus placeholder=\"email\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 20), "html", null, true);
        echo "\" required>
        </div>
        <div>
            <label for=\"password\">password</label>
            <input type=\"password\" name=\"password\" id=\"password\" autofocus placeholder=\"password\" required pattern=\"^(?=.*[A-Za-z])(?=.*\\d)[A-Za-z\\d]{6,}\$\" title=\"Minimum 6 chars, at least one letter and number\">
        </div>
        <button type=\"submit\">Submit</button>
    </form>
";
    }

    public function getTemplateName()
    {
        return "login/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 20,  93 => 17,  88 => 14,  79 => 12,  75 => 11,  71 => 9,  69 => 8,  66 => 7,  62 => 6,  56 => 4,  48 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login/index.html", "E:\\laragon\\laragon\\www\\myownframeworklogin\\App\\Views\\login\\index.html");
    }
}
