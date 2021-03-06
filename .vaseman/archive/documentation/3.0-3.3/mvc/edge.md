---
layout: documentation.twig
title: Edge Templates

---

Edge is a [Blade](https://laravel.com/docs/5.1/blade) compatible template engine, provides same syntax to support
Blade template files, but has more powerful extending interfaces.

## Use Edge Engine in View

Get Edge View in Controller

``` php
$view = $this->getView('sakura', 'html', 'edge');

$view->set('title', 'Hello World~~~!');
```

Or set renderer in view class:

``` php
use Windwalker\Core\View\HtmlView;

class SakuraHtmlView extends HtmlView
{
    protected $renderer = 'edge'; // Or RendererHelper::EDGE
}
```

Then we create a template file in `src/Flower/Templates/sakura/default.edge.php` or (`default.blade.php`):

``` php
<h1>{{ $title }}</h1>
```

Result:

``` html
<h1>Hello World~~~!</h1>
```

## Edge Syntax

Most of Edge syntax are same as Blade.

### Echoing Data

Display a variable by `{{ ... }}`

``` php
Hello {{ $title }}
```

Unescaped echoing.

``` php
My name is {!! $form->input('name') !!}
```

### Control Structures

#### If Statement

Use `@if ... @else` directive.

``` php
@if (count($flower) == 1)
    I have one flower!
@elseif (count($flower) > 1)
    I have many flkowers!
@else
    I don't have any flower!
@endif
```

Unless directive

``` html
@unless ($user->isAdmin())
    You are not logged in.
@endunless
```

### Loops

Edge provides simple directives similar to PHP loop structure.

``` php
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This user is: {{ $user->name }}</p>
@endforeach

@forelse ($articles as $article)
    <li>{{ $article->title }}</li>
@empty
    <p>No article here</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile
```

You might need to break or skip a loop.

``` php
@foreach ($users as $user)

    @if (!$user->id)
        @continue
    @endif

    <p>This user is: {{ $user->name }}</p>

    @if ($user->id >= 10)
        @break
    @endif

@endforeach
```

Or add conditions to these two directives.

``` php
@continue(!$user->id)

@break($user->id >= 10)
```

## Layouts

We can define some sections in a root template.

``` html
<!-- tmpl/layouts/root.edge.php -->
<html>
    <head>
        <title>@yield('page_title')</title>
    </head>
    <body>
        @section('body')
            The is root body
        @show
    </body>
</html>
```

Now we can add an child template to extends root template.

``` php
@extends('layouts.root')

@section('page_title', 'My Page Title')

@section('content')
    <p>This is my body content.</p>
@endsection
```

The final template rendered:

``` html
<html>
    <head>
        <title>My Page Title</title>
    </head>
    <body>
        <p>This is my body content.</p>
    </body>
</html>
```

More directive and usages please see [Blade](https://laravel.com/docs/5.2/blade#defining-a-layout)

## Extending Edge

We can create Extension class to add multiple directives and global variables to Edge.

``` php
class MyExtension implements \Windwalker\Edge\Extension\EdgeExtensionInterface
{
	public function getName()
	{
		return 'my_extension';
	}

	public function getDirectives()
	{
		return array(
			'upper' => array($this, 'upper'),
			'lower' => array($this, 'lower'),
		);
	}

	public function getGlobals()
	{
		return array(
			'flower' => 'sakura'
		);
	}

	public function getParsers()
	{
		return array();
	}

	public function upper($expression)
	{
		return "<?php echo strtoupper$expression; ?>";
	}

	public function lower($expression)
	{
		return "<?php echo strtolower$expression; ?>";
	}
}

// Inject this extension to Edge

\Windwalker\Renderer\Edge\GlobalContainer::addExtension(new MyExtension[, $name = null]);
```

Use our new directive:

``` php
<h1>@upper('hello')</h2>

<!-- Result: <h1>HELLO</h1> -->
```

See [Edge Package](https://github.com/ventoviro/windwalker/tree/master/src/Edge)
