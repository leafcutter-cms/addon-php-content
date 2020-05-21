 <h1>Cacheable PHP-generated page</h1>

<p>
    Unlike the home page, this page is set as not dynamic, so it can be cached by output caching.
    Marking a page as cacheable is as simple as calling <code>$this->page()->setDynamic(false);</code> in your PHP.
</p>

<p>Timestamp: <?php echo time(); ?></p>

<p>Random: <?php echo random_int(0, PHP_INT_MAX); ?></p>

<p>
    <code>foo</code> GET parameter: <?php echo htmlentities($this->param('foo')); ?>
    <br>
    Note that caching respects GET parameters.
</p>

<p><a href="cacheable.html">Cacheable example page</a></p>

<?php
$this->page()->setDynamic(false);
