# twig-once

MicroExtension for Twig template library.
Can be used when need restrict once some part of code.

**`twig/twig` library is required**. 

## How to use.

1.Require this extension with your composer

```shell
composer require cf-git/twig-once
```

2.include autoload file in your php project (if it not included);

```php
include_once('vendor/autoload.php');
```

3.add token parser to Twig\Environment
```php
$twig = new \Twig\Environment($loader, $config);
$twig->addExtension(new \CFGit\TwigEngine\Extensions\Once\OnceExtension())

```
or like this
```php
$twig = new \Twig\Environment($loader, $config);
$twig->addTokenParser(new \CFGit\TwigEngine\Extensions\Once\OnceTokenParser());

```

4.Then use twig documentation! 

And use it.

### If you do right. You gets some like this.

```twig
{{-- Main content --}}

{% for i in range(0, 5) %}
    <div>{{ i }}</div>
    {% once hello %}
    <script>console.log("[{{ i }}]Hello world!")</script>
    {% endonce %}
{% endfor %}
```

outputs

```html
<div>0</div>
<script>console.log("[0] Hello world!")</script>
<div>1</div>
<div>2</div>
<div>3</div>
<div>4</div>
<div>5</div>
```

### Same with included files

```twig
{{-- Main content --}}

{% for i in range(0,5) %}
  {% include "x.twig" with({(i): i}) %}
{% endfor %}
```

outputs

```html
{{-- x.twig content --}}
<!-- 0 -->
<!-- [0] Hello world! -->
<!-- 1 -->
<!-- 2 -->
<!-- 3 -->
<!-- 4 -->
<!-- 5 -->
```