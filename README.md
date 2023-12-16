# twig-once

Once content including...

Like this.

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